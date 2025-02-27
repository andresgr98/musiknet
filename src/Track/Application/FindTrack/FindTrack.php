<?php

namespace App\Track\Application\FindTrack;

use App\Track\Domain\TrackRepository;

class FindTrack
{
    public function __construct(private readonly TrackRepository $trackRepository) {}

    public function find($trackId)
    {
        return $this->trackRepository->findOne($trackId);
    }
}
