<?php

namespace App\TrackType\Infrastructure;

use App\Entity\TrackType;
use App\Shared\DoctrineRepository;
use App\TrackType\Domain\TrackTypeRepository;

class TrackTypeMySqlRepository extends DoctrineRepository implements TrackTypeRepository
{
    public function findOne(int $id): ?TrackType
    {
        return $this->entityManager()->getRepository(TrackType::class)->find($id);
    }
}
