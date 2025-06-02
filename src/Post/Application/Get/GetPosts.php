<?php

namespace App\Post\Application\Get;

use App\Entity\User;
use App\Post\Domain\PostRepository;

class GetPosts
{
    public function __construct(private readonly PostRepository $postRepository) {}

    public function getPostsForUser(User $user, int $page, int $limit): array
    {
        return [
            "data" => $this->postRepository->findFeedForUser($user->getId(), $page, $limit),
            "totalRecords" => $this->postRepository->countFeedForUser($user->getId())
        ];
    }
}
