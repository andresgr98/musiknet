<?php

namespace App\User\Application\Get;

class GetUsersForSwiperQuery
{

    public function __construct(
        private readonly int $id,
        private readonly int $page,
        private readonly int $limit
    ) {}

    public function id(): string
    {
        return $this->id;
    }

    public function page(): string
    {
        return $this->page;
    }

    public function limit(): string
    {
        return $this->limit;
    }
}
