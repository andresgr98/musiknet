<?php

namespace App\User\Application\Get;

class GetUsersForSwiperQuery
{

    public function __construct(private readonly int $id) {}

    public function id(): string
    {
        return $this->id;
    }
}
