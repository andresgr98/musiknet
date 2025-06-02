<?php

namespace App\Track\Domain;

use App\Entity\Track;
use App\Entity\TrackType;
use App\Entity\User;

interface TrackRepository
{
    public function findOne(string $uuid): ?Track;
    public function findByUserAndTrackType(User $user, TrackType $trackType): array;
    public function create(User $user, TrackType $trackType): ?Track;
    public function delete(Track $track): void;
}
