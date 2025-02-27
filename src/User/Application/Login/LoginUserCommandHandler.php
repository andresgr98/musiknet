<?php

namespace App\User\Application\Login;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class LoginUserCommandHandler
{
    public function __construct(private readonly LoginUser $loginUser) {}

    public function __invoke(LoginUserCommand $command)
    {
        return $this->loginUser->loginByEmail($command->email(), $command->password());
    }
}
