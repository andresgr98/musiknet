<?php

namespace App\Post\Application\Get;

use App\Entity\User;

class GetPostsQuery
{
    public function __construct(private readonly User $user) {}

    public function user(): User
    {
        return $this->user;
    }
}
