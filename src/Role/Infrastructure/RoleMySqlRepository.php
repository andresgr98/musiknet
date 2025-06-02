<?php

namespace App\Role\Infrastructure;

use App\Entity\Role;
use App\Role\Domain\RoleRepository;
use App\Shared\DoctrineRepository;

class RoleMySqlRepository extends DoctrineRepository implements RoleRepository
{
    public function findAll(): array
    {
        return $this->entityManager()->getRepository(Role::class)->findAll();
    }

    public function findOne(int $id): ?Role
    {
        return $this->entityManager()->getRepository(Role::class)->findOneBy(['id' => $id]);
    }
}
