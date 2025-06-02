<?php

namespace App\Track\Infrastructure;

use App\Entity\Track;
use App\Entity\TrackType;
use App\Entity\User;
use App\Shared\DoctrineRepository;
use App\Track\Domain\TrackRepository;
use Symfony\Component\Uid\Uuid;

class TrackMySqlRepository extends DoctrineRepository implements TrackRepository
{
    public function findOne(string $uuid): ?Track
    {
        return $this->repository(Track::class)->findOneBy(["uuid" => $uuid]);
    }

    public function create(User $user, TrackType $trackType): Track
    {
        $uuid = Uuid::v4()->toString();
        $track = new Track();
        $track->setUser($user);
        $track->setUuid($uuid);
        $track->setType($trackType);
        $this->entityManager()->persist($track);
        $this->entityManager()->flush();
        return $track;
    }

    public function findByUserAndTrackType(User $user, TrackType $trackType): array
    {
        return $this->repository(Track::class)->findBy(["type" => $trackType->getId(), "user" => $user]);
    }

    public function delete(Track $track): void
    {
        $this->remove($track);
        $this->entityManager()->flush();
    }
}
