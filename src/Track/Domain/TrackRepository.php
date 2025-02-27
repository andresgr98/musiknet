<?php

namespace App\Track\Domain;

use App\Entity\Track;

interface TrackRepository
{
    public function findOne(int $id): Track;
    public function save(Track $track): Track;
}
