<?php

namespace App\Post\Application\Get;

use App\Entity\User;

class GetUserPostsQuery
{
    public function __construct(
        private readonly User $currentUser,
        private readonly int $userId,
        private readonly int $page,
        private readonly int $limit
    ) {}

    public function currentUser(): User
    {
        return $this->currentUser;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function limit(): int
    {
        return $this->limit;
    }
}
