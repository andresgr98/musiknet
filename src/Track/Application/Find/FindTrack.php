<?php

namespace App\Track\Application\Find;

use App\Entity\Track;
use App\Track\Domain\TrackRepository;
use App\Track\Domain\TrackStorageRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FindTrack
{
    public function __construct(private readonly TrackRepository $trackRepository, private readonly TrackStorageRepository $trackStorageRepository) {}

    public function find($trackUuid): UploadedFile
    {
        $track = $this->trackRepository->findOne($trackUuid);
        if (!$track) {
            throw new NotFoundHttpException('Track not found');
        }
        $trackFile = $this->trackStorageRepository->findOne($track->getUuid());
        if (!$trackFile) {
            throw new NotFoundHttpException('Track file not found');
        }
        return $trackFile;
    }

    public function getTrackData(string $trackUuid): ?Track
    {
        $track = $this->trackRepository->findOne($trackUuid);
        if (!$track) {
            throw new NotFoundHttpException('Track not found');
        }
        return $track;
    }
}
