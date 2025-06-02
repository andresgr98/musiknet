<?php

namespace App\User\Application\Get;

use App\Entity\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetUserQueryHandler
{
    public function __construct(private readonly GetUser $getUser) {}

    public function __invoke(GetUserQuery $query): User
    {
        return $this->getUser->get($query->id());
    }
}
