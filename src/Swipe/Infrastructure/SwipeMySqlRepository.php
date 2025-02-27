<?php

namespace App\Swipe\Infrastructure;

use App\Entity\Swipe;
use App\Entity\User;
use App\Shared\DoctrineRepository;
use App\Swipe\Domain\SwipeRepository;

class SwipeMySqlRepository extends DoctrineRepository implements SwipeRepository
{

    public function findOne(int $id): User
    {
        return $this->repository(Swipe::class)->findOneBy(["id" => $id]);
    }

    public function findOneBySwipeUsers(int $userId, int $swipedUserId): ?Swipe
    {
        return $this->repository(Swipe::class)->findOneBy([
            'user' => $userId,
            'swipedUser' => $swipedUserId,
        ]);
    }

    public function swipeUser(int $currentUserId, int $swipedUserId, bool $liked): void
    {
        $connection = $this->entityManager()->getConnection();


        $queryBuilder = $connection->createQueryBuilder();
        try {
            $queryBuilder
                ->insert('swipe')
                ->values([
                    'user_id' => ':current_user_id',
                    'swiped_user_id' => ':swiped_user_id',
                    'liked' => ':liked',
                    'updated_at' => 'CURRENT_TIMESTAMP()',
                ])
                ->setParameter('current_user_id', $currentUserId)
                ->setParameter('swiped_user_id', $swipedUserId)
                ->setParameter('liked', $liked);


            $queryBuilder->executeQuery();
        } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {

            $queryBuilder = $connection->createQueryBuilder();
            $queryBuilder
                ->update('swipe')
                ->set('liked', ':liked')
                ->set('updated_at', 'CURRENT_TIMESTAMP()')
                ->where('user_id = :current_user_id')
                ->andWhere('swiped_user_id = :swiped_user_id')
                ->setParameter('current_user_id', $currentUserId)
                ->setParameter('swiped_user_id', $swipedUserId)
                ->setParameter('liked', $liked);


            $queryBuilder->executeQuery();
        }
    }

    public function save(Swipe $swipe): void
    {
        $this->persist($swipe);
    }
}
