<?php

namespace App\Post\Application\Get;

use App\Entity\Post;
use App\Entity\User;
use App\Post\Domain\PostRepository;

class GetPost
{
    public function __construct(private readonly PostRepository $postRepository) {}

    public function get(int $postId): ?Post
    {
        return $this->postRepository->findOne($postId);
    }
}
