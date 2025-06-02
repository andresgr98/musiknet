<?php

namespace App\Track\Application\Create;

use App\Entity\Track;
use App\Entity\TrackType;
use App\Entity\User;
use App\Shared\Domain\TransactionalInterface;
use App\Track\Domain\TrackRepository;
use App\Track\Domain\TrackStorageRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Throwable;

class CreateTrack
{
    public function __construct(
        private readonly TrackRepository $trackRepository,
        private readonly TrackStorageRepository $trackStorageRepository,
        private readonly TransactionalInterface $transactional
    ) {}

    public function create(UploadedFile $trackFile, User $user, TrackType $trackType): ?Track
    {
        return $this->transactional->transactional(function () use ($trackFile, $user, $trackType) {
            $track = $this->trackRepository->create($user, $trackType);
            $fileCreated = false;

            try {
                $this->trackStorageRepository->create($trackFile, $track->getUuid());
                $fileCreated = true;

                return $track;
            } catch (Throwable $e) {
                if ($fileCreated) {
                    $this->trackStorageRepository->delete($track->getUuid());
                }
                throw $e;
            }
        });
    }
}
