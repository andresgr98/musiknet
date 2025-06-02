<?php

namespace App\Role\Application;

use App\Role\Domain\RoleRepository;

class GetAllRoles
{
    public function __construct(private readonly RoleRepository $languageRepository) {}

    public function get(): array
    {
        return $this->languageRepository->findAll();
    }
}
