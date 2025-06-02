<?php

namespace App\User\Application\Update;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateUserPictureCommandHandler
{
    public function __construct(private readonly UpdateUserPicture $updateUserPicture) {}

    public function __invoke(UpdateUserPictureCommand $command): void
    {
        $this->updateUserPicture->update(
            $command->file(),
            $command->user()
        );
    }
}
