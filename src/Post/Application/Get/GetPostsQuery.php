<?php

namespace App\Post\Application\Get;

use App\Entity\User;

class GetPostsQuery
{
    public function __construct(private readonly User $user, private readonly int $page, private readonly int $limit) {}

    public function user(): User
    {
        return $this->user;
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
