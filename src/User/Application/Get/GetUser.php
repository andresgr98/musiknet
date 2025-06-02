<?php

namespace App\User\Application\Get;

use App\Entity\User;
use App\User\Domain\UserRepository;

class GetUser
{
    public function __construct(private readonly UserRepository $repo) {}

    public function get(int $id): ?User
    {
        return $this->repo->findOne($id);
    }

    public function getByEmail(string $email): User
    {
        return $this->repo->findOneByEmail($email);
    }
}
