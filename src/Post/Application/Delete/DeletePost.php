<?php

namespace App\Post\Application\Delete;

use App\Entity\Post;
use App\Entity\User;
use App\Post\Application\Get\GetPost;
use App\Post\Domain\PostRepository;
use App\User\Domain\Exception\PostException;

class DeletePost
{
    public function __construct(private readonly PostRepository $postRepository, private readonly GetPost $getPost) {}

    public function create(int $postId, User $currentUser): void
    {
        $post = $this->getPost->get($postId);
        if ($post === null) {
            throw new PostException('Post not found', 404);
        }

        if ($post->getUser()->getId() !== $currentUser->getId()) {
            throw new PostException('You are not allowed to delete this post', 403);
        }

        $this->postRepository->delete($post);
    }
}
