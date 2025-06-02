<?php

namespace App\User\Application\RefreshToken;

class RefreshTokenCommand
{
    public function __construct(
        private readonly string $refreshToken
    ) {}

    public function refreshToken(): string
    {
        return $this->refreshToken;
    }
}
