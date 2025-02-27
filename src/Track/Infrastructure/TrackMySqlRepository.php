<?php

namespace App\Track\Infrastructure;

use App\Entity\Track;
use App\Shared\DoctrineRepository;
use App\Track\Domain\TrackRepository;

class TrackMySqlRepository extends DoctrineRepository implements TrackRepository
{
    public function findOne(int $id): Track
    {
        return $this->repository(Track::class)->findOneBy(["id" => $id]);
    }

    public function save(Track $track): Track
    {
        $this->entityManager()->persist($track);
        $this->entityManager()->flush();
        return $track;
    }
}
