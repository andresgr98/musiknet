<?php

namespace App\User\Application\Get;

use App\User\Domain\UserRepository;

class GetUsersForSwiper
{
    public function __construct(private readonly UserRepository $repo) {}

    public function get(int $currentUserId, int $page, int $limit): array
    {
        return [
            "data" => $this->repo->findUsersForSwiper($currentUserId, $page, $limit),
            "totalRecords" => $this->repo->countUsersForSwiper($currentUserId)
        ];
    }
}
