<?php

namespace App\Post\Application\Delete;

use App\Entity\User;

class DeletePostCommand
{

    public function __construct(
        private readonly string $postId,
        private readonly User $user
    ) {}

    public function postId(): string
    {
        return $this->postId;
    }

    public function user(): User
    {
        return $this->user;
    }
}
