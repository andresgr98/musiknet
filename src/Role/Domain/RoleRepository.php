<?php

namespace App\Role\Domain;

use App\Entity\Role;

interface RoleRepository
{
    public function findOne(int $id): ?Role;

    public function findAll(): array;
}
