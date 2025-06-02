<?php

namespace App\Swipe\Domain;

use App\Entity\Swipe;
use App\Entity\User;

interface SwipeRepository
{
    public function findOne(int $id): User;

    public function findOneBySwipeUsers(int $userId, int $swipedUserId): ?Swipe;

    public function swipeUser(int $currentUserId, int $swipedUserId, bool $liked): void;

    public function save(Swipe $swipe): void;
}
