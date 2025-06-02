<?php

namespace App\User\Application\Create;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserCommandHandler
{
    public function __construct(
        private readonly CreateUser $createUser
    ) {}

    public function __invoke(CreateUserCommand $command)
    {
        $this->createUser->create(
            $command->email(),
            $command->password(),
            $command->firstName(),
            $command->lastName(),
            $command->phone(),
            $command->location(),
            $command->profilePictureUrl(),
            $command->artistName(),
            $command->genderId(),
            $command->userGenres(),
            $command->userRoles(),
            $command->userLanguages(),
            $command->trackUrl1(),
            $command->trackUrl2(),
            $command->trackUrl3()
        );
    }
}
