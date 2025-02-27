<?php

namespace App\Post\Application\Get;

use App\Entity\User;

class GetUserPostsQuery
{
    public function __construct(
        private readonly User $currentUser,
        private readonly int $userId
    ) {}

    public function currentUser(): User
    {
        return $this->currentUser;
    }

    public function userId(): int
    {
        return $this->userId;
    }
}
