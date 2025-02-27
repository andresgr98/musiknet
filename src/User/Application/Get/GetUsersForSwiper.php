<?php

namespace App\User\Application\Get;

use App\User\Domain\UserRepository;

class GetUsersForSwiper
{
    public function __construct(private readonly UserRepository $repo) {}

    public function get(int $currentUserId): array
    {
        return $this->repo->findUsersForSwiper($currentUserId);
    }
}
