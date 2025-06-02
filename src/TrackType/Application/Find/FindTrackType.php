<?php

namespace App\TrackType\Application\Find;

use App\Entity\TrackType;
use App\TrackType\Domain\TrackTypeRepository;
use RuntimeException;

class FindTrackType
{
    public function __construct(
        private readonly TrackTypeRepository $trackTypeRepository
    ) {}

    public function find(int $typeId): TrackType
    {
        $trackType = $this->trackTypeRepository->findOne($typeId);
        if (!$trackType) {
            throw new RuntimeException('Track type not found');
        }

        return $trackType;
    }
}
