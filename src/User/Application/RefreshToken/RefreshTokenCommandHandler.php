<?php

namespace App\User\Application\RefreshToken;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RefreshTokenCommandHandler
{
    public function __construct(
        private readonly RefreshToken $refreshToken
    ) {}

    public function __invoke(RefreshTokenCommand $command): string
    {
        return $this->refreshToken->refresh($command->refreshToken());
    }
}
