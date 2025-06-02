<?php

namespace App\Role\Application;

use App\Entity\Role;
use App\Role\Domain\RoleRepository;

class GetRole
{
    public function __construct(private readonly RoleRepository $roleRepository) {}

    public function get(int $id): ?Role
    {
        return $this->roleRepository->findOne($id);
    }
}
