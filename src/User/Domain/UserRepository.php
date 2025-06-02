<?php

namespace App\User\Domain;

use App\Entity\User;

interface UserRepository
{
    public function findOne(int $id): ?User;

    public function findOneByEmail(string $email): ?User;

    public function findUsersForSwiper(int $currentUserId, int $page, int $limit): array;

    public function countUsersForSwiper(int $currentUserId): int;

    public function save(User $user): User;
}
