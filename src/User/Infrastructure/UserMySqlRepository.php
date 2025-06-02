<?php

namespace App\User\Infrastructure;

use App\Entity\User;
use App\Shared\DoctrineRepository;
use App\User\Domain\UserRepository;
use DateInterval;
use DateTimeImmutable;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UserMySqlRepository extends DoctrineRepository implements UserRepository
{
    public function findOne(int $id): ?User
    {
        return $this->repository(User::class)->findOneBy(["id" => $id]);
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->repository(User::class)->findOneBy(["email" => $email]);
    }

    public function findUsersForSwiper(int $currentUserId, int $page, int $limit): array
    {
        $cooldown = new DateInterval('P2M');

        $query = $this->entityManager()
            ->createQueryBuilder()
            ->select('u AS user, r, g, swipe.liked')
            ->from(User::class, 'u')
            ->leftJoin('u.userRoles', 'r')
            ->leftJoin('u.userGenres', 'g')
            ->leftJoin('App\Entity\Swipe', 'swipe', 'WITH', 'swipe.user = u AND swipe.swipedUser = :currentUserId')
            ->where('NOT EXISTS (
            SELECT swipe1 FROM App\Entity\Swipe swipe1
            WHERE swipe1.user = :currentUserId 
            AND swipe1.swipedUser = u
        )')
            ->andWhere('u != :currentUserId')
            ->orWhere('EXISTS (
            SELECT swipe2 FROM App\Entity\Swipe swipe2
            WHERE swipe2.user = :currentUserId 
            AND swipe2.swipedUser = u 
            AND swipe2.liked = 0
            AND swipe2.updatedAt < :intervalAgo
        )')
            ->setParameter('currentUserId', $currentUserId)
            ->setParameter('intervalAgo', (new DateTimeImmutable())->sub($cooldown))
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery();

        $paginator = new Paginator($query, $fetchJoinCollection = true);

        return iterator_to_array($paginator);
    }

    public function countUsersForSwiper(int $currentUserId): int
    {
        $cooldown = new DateInterval('P2M');

        return (int) $this->entityManager()
            ->createQueryBuilder()
            ->select('COUNT(u)')
            ->from(User::class, 'u')
            ->leftJoin('App\Entity\Swipe', 'swipe', 'WITH', 'swipe.user = u AND swipe.swipedUser = :currentUserId')
            ->where('NOT EXISTS (
            SELECT swipe1 FROM App\Entity\Swipe swipe1
            WHERE swipe1.user = :currentUserId 
            AND swipe1.swipedUser = u
        )')
            ->andWhere('u != :currentUserId')
            ->orWhere('EXISTS (
            SELECT swipe2 FROM App\Entity\Swipe swipe2
            WHERE swipe2.user = :currentUserId 
            AND swipe2.swipedUser = u 
            AND swipe2.liked = 0
            AND swipe2.updatedAt < :intervalAgo
        )')
            ->setParameter('currentUserId', $currentUserId)
            ->setParameter('intervalAgo', (new DateTimeImmutable())->sub($cooldown))
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function save(User $user): User
    {
        $this->entityManager()->persist($user);
        $this->entityManager()->flush();
        return $user;
    }
}
