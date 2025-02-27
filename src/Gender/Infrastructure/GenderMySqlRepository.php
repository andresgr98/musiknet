<?php

namespace App\Gender\Infrastructure;

use App\Entity\Gender;
use App\Gender\Domain\GenderRepository;
use App\Shared\DoctrineRepository;

class GenderMySqlRepository extends DoctrineRepository implements GenderRepository
{
    public function findOne(int $id): Gender
    {
        return $this->repository(Gender::class)->findOneBy(["id" => $id]);
    }
}
