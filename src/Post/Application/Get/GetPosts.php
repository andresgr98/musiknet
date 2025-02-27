<?php

namespace App\Post\Application\Get;

use App\Entity\User;
use App\Post\Domain\PostRepository;

class GetPosts
{
    public function __construct(private readonly PostRepository $postRepository) {}

    public function getPostsForUser(User $user): array
    {
        return $this->postRepository->findFeedForUser($user->getId());
    }
}
