<?php

namespace App\TrackType\Domain;

use App\Entity\TrackType;

interface TrackTypeRepository
{
    public function findOne(int $id): ?TrackType;
}
