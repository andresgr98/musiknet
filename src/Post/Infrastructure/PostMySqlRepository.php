<?php

namespace App\Post\Infrastructure;

use App\Entity\Post;
use App\Post\Domain\PostRepository;
use App\Shared\DoctrineRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PostMySqlRepository extends DoctrineRepository implements PostRepository
{
    public function findOne(int $id): ?Post
    {
        return $this->entityManager()->getRepository(Post::class)->find($id);
    }

    public function findFeedForUser(int $currentUserId, int $page, int $limit): array
    {
        $query = $this->entityManager()->createQueryBuilder();

        $query->select('p')
            ->from('App\Entity\Post', 'p')
            ->join('p.user', 'u')
            ->where(
                $query->expr()->orX(
                    $query->expr()->exists(
                        $this->entityManager()->createQueryBuilder()
                            ->select('s1.id')
                            ->from('App\Entity\Swipe', 's1')
                            ->where('s1.user = :currentUser')
                            ->andWhere('s1.swipedUser = u.id')
                            ->andWhere('s1.liked = 1')
                            ->andWhere(
                                $query->expr()->exists(
                                    $this->entityManager()->createQueryBuilder()
                                        ->select('s2.id')
                                        ->from('App\Entity\Swipe', 's2')
                                        ->where('s2.user = u.id')
                                        ->andWhere('s2.swipedUser = :currentUser')
                                        ->andWhere('s2.liked = 1')
                                        ->getDQL()
                                )
                            )
                            ->getDQL()
                    ),
                    $query->expr()->eq('u.id', ':currentUser')
                )
            )
            ->orderBy('p.createdAt', 'DESC')
            ->setParameter('currentUser', $currentUserId)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery();
        $paginator = new Paginator($query, $fetchJoinCollection = true);

        return iterator_to_array($paginator);
    }

    public function countFeedForUser(int $currentUserId): int
    {
        $query = $this->entityManager()->createQueryBuilder();

        $query->select('COUNT(p.id)')
            ->from('App\Entity\Post', 'p')
            ->join('p.user', 'u')
            ->where(
                $query->expr()->orX(
                    $query->expr()->exists(
                        $this->entityManager()->createQueryBuilder()
                            ->select('s1.id')
                            ->from('App\Entity\Swipe', 's1')
                            ->where('s1.user = :currentUser')
                            ->andWhere('s1.swipedUser = u.id')
                            ->andWhere('s1.liked = 1')
                            ->andWhere(
                                $query->expr()->exists(
                                    $this->entityManager()->createQueryBuilder()
                                        ->select('s2.id')
                                        ->from('App\Entity\Swipe', 's2')
                                        ->where('s2.user = u.id')
                                        ->andWhere('s2.swipedUser = :currentUser')
                                        ->andWhere('s2.liked = 1')
                                        ->getDQL()
                                )
                            )
                            ->getDQL()
                    ),
                    $query->expr()->eq('u.id', ':currentUser')
                )
            )
            ->setParameter('currentUser', $currentUserId);

        return (int) $query->getQuery()->getSingleScalarResult();
    }

    public function findUserPosts(int $userId, int $page, int $limit): array
    {
        $query = $this->entityManager()->createQueryBuilder();

        $query->select('p')
            ->from('App\Entity\Post', 'p')
            ->where('p.user = :userId')
            ->orderBy('p.createdAt', 'DESC')
            ->setParameter('userId', $userId)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery();
        $paginator = new Paginator($query, $fetchJoinCollection = true);

        return iterator_to_array($paginator);
    }

    public function countUserPosts(int $userId): int
    {
        $query = $this->entityManager()->createQueryBuilder();

        $query->select('COUNT(p.id)')
            ->from('App\Entity\Post', 'p')
            ->where('p.user = :userId')
            ->setParameter('userId', $userId);

        return (int) $query->getQuery()->getSingleScalarResult();
    }

    public function save(Post $post): Post
    {
        $this->entityManager()->persist($post);
        $this->entityManager()->flush();
        return $post;
    }

    public function delete(Post $post): void
    {
        $this->entityManager()->remove($post);
        $this->entityManager()->flush();
    }
}
