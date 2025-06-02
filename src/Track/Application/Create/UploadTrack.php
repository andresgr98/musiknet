<?php

namespace App\Track\Application\Create;

use App\Entity\Track;
use App\Entity\User;
use App\Track\Domain\CheckUserTracks;
use App\TrackType\Application\Find\FindTrackType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadTrack
{
    public function __construct(
        private readonly CreateTrack $createTrack,
        private readonly FindTrackType $findTrackType,
        private readonly CheckUserTracks $checkUserTracks
    ) {}

    public function upload(UploadedFile $trackFile, User $user, int $trackTypeId): ?Track
    {
        $trackType = $this->findTrackType->find($trackTypeId);
        $this->checkUserTracks->check($user, $trackType);
        return $this->createTrack->create($trackFile, $user, $trackType);
    }
}
