<?php

namespace App\Track\Application\Delete;

use App\Entity\Track;
use App\Shared\Domain\TransactionalInterface;
use App\Track\Domain\TrackRepository;
use App\Track\Domain\TrackServiceRepository;
use App\Track\Domain\TrackStorageRepository;
use RuntimeException;
use Throwable;

class DeleteTrack
{
    public function __construct(
        private readonly TransactionalInterface $transactional,
        private readonly TrackRepository $trackRepository,
        private readonly TrackStorageRepository $trackStorageRepository,
    ) {}

    public function delete(Track $track): void
    {
        $this->transactional->transactional(function () use ($track) {
            $this->trackRepository->delete($track);
            try {
                $this->trackStorageRepository->delete($track->getUuid());
            } catch (Throwable $th) {
                throw new RuntimeException(
                    sprintf('Failed to delete track file for UUID %s: %s', $track->getUuid(), $th->getMessage()),
                    0,
                    $th
                );
            }
        });
    }
}
