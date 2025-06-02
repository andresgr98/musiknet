<?php

namespace App\Swipe\Application;

use App\Entity\User;

class SwipeUserCommand
{
    public function __construct(
        private readonly User $user,
        private readonly int $swipedUserId,
        private readonly bool $liked
    ) {}

    public function user(): User
    {
        return $this->user;
    }

    public function swipedUserId(): int
    {
        return $this->swipedUserId;
    }

    public function liked(): bool
    {
        return $this->liked;
    }
}
