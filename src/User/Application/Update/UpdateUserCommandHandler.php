<?php

namespace App\User\Application\Update;

use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateUserCommandHandler
{
    public function __construct(private readonly UpdateUser $updateUser) {}

    public function __invoke(UpdateUserCommand $command): void
    {
        $this->updateUser->update(
            $command->artistName(),
            $command->firstName(),
            $command->lastName(),
            $command->phone(),
            $command->location(),
            $command->profilePictureUrl(),
            $command->userGenres(),
            $command->userRoles(),
            $command->userLanguages()
        );
    }
}
