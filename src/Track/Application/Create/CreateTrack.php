<?php

namespace App\Track\Application\Create;

use App\Entity\Track;
use App\Entity\User;
use App\Track\Domain\TrackRepository;

class CreateTrack
{
    public function __construct(private readonly TrackRepository $trackRepository) {}

    public function create(string $trackUrl, User $user): Track
    {
        $track = new Track();
        $track->setTrackUrl($trackUrl);
        $track->setUser($user);
        return $this->trackRepository->save($track);
    }
}
