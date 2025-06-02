<?php

namespace App\Track\Application\Find;

use App\Entity\User;

final class FindTrackQuery
{
    public function __construct(private readonly string $uuid) {}

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
