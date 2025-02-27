<?php

namespace App\User\Application\RefreshToken;

use App\User\Application\Get\GetUser;
use App\User\Domain\TokenService;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class RefreshToken
{
    public function __construct(
        private readonly TokenService $tokenService,
        private readonly GetUser $getUser
    ) {}

    public function refresh(string $refreshToken): string
    {
        try {
            $payload = $this->tokenService->validateRefreshToken($refreshToken);
            $user = $this->getUser->getByEmail($payload['username']);
            $newAccessToken = $this->tokenService->generateAccessToken($user);
            return $newAccessToken;
        } catch (\Exception $e) {
            throw new AuthenticationException('Invalid refresh token');
        }
    }
}
