<?php

namespace App\Track\Domain;

use App\Entity\TrackType;
use App\Entity\User;
use Exception;

class CheckUserTracks
{
    public function __construct(
        private readonly TrackRepository $trackRepository,
        private readonly TrackStorageRepository $trackStorageRepository
    ) {}

    public function check(User $user, TrackType $trackType): void
    {
        $tracks = $this->trackRepository->findByUserAndTrackType($user, $trackType);
        if ($trackType->getId() == TrackType::TYPE_MAIN) {
            if (count($tracks) > 0) {
                throw new Exception("User already has a main track.", 400);
            }
        }
        if ($trackType->getId() == TrackType::TYPE_PROFILE) {
            if (count($tracks) >= 2) {
                throw new Exception("User already has two profile tracks.", 400);
            }
        }
    }
}
