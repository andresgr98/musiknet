<?php

namespace App\User\Application\Get;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetUsersForSwiperQueryHandler
{
    public function __construct(private readonly GetUsersForSwiper $getUsers) {}

    public function __invoke(GetUsersForSwiperQuery $query): array
    {
        return $this->getUsers->get($query->id(), $query->page(), $query->limit());
    }
}
