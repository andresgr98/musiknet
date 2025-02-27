<?php

namespace App\Post\Infrastructure;

use App\Entity\Post;
use App\Post\Domain\PostRepository;
use App\Shared\DoctrineRepository;

class PostMySqlRepository extends DoctrineRepository implements PostRepository
{
    public function findOne(int $id): ?Post
    {
        return $this->entityManager()->getRepository(Post::class)->find($id);
    }

    public function findFeedForUser(int $currentUserId): array
    {
        $qb = $this->entityManager()->createQueryBuilder();

        $qb->select('p')
            ->from('App\Entity\Post', 'p')
            ->join('p.user', 'u')
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->exists(
                        $this->entityManager()->createQueryBuilder()
                            ->select('s1.id')
                            ->from('App\Entity\Swipe', 's1')
                            ->where('s1.user = :currentUser')
                            ->andWhere('s1.swipedUser = u.id')
                            ->andWhere('s1.liked = 1')
                            ->andWhere(
                                $qb->expr()->exists(
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
                    $qb->expr()->eq('u.id', ':currentUser')
                )
            )
            ->orderBy('p.createdAt', 'DESC')
            ->setParameter('currentUser', $currentUserId);

        return $qb->getQuery()->getResult();
    }

    public function findUserPosts(int $userId): array
    {
        return $this->entityManager()->getRepository(Post::class)->findBy(['user' => $userId]);
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
