<?php

namespace App\Track\Application\Update;

use App\Entity\TrackType;
use App\Entity\User;
use App\Shared\Domain\TransactionalInterface;
use App\Track\Application\Create\UploadTrack;
use App\Track\Application\Delete\DeleteTrack;
use App\Track\Application\Find\FindTrack;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class ReplaceProfileTrack
{
    public function __construct(
        private readonly TransactionalInterface $transactional,
        private readonly FindTrack $findTrack,
        private readonly DeleteTrack $deleteTrack,
        private readonly UploadTrack $uploadTrack,
    ) {}

    public function replace(UploadedFile $file, string $uuid, User $user)
    {
        $this->transactional->transactional(function () use ($file, $uuid, $user) {
            $track = $this->findTrack->getTrackData($uuid);
            $trackType = $track->getType();
            if ($trackType->getId() == TrackType::TYPE_POST) {
                throw new InvalidArgumentException('Cannot replace a post track.', Response::HTTP_BAD_REQUEST);
            }
            $this->deleteTrack->delete($track);
            $this->uploadTrack->upload($file, $user, $trackType->getId());
        });
    }
}
