<?php

namespace App\User\Domain;

use App\Entity\User;
use App\User\Domain\Exception\InvalidJwtTokenException;
use DateTime;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Throwable;

class TokenService
{
    private const ACCESS_TOKEN_TYPE = 'access';
    private const REFRESH_TOKEN_TYPE = 'refresh';

    public function __construct(
        private readonly JWTTokenManagerInterface $jwtManager
    ) {}

    public function generateAccessToken(User $user): string
    {
        $exp = $_ENV['ACCESS_TOKEN_EXPIRATION'] ?? '+15 minutes';
        $expiration = new DateTime($exp);
        $payload = [
            'type' => self::ACCESS_TOKEN_TYPE,
            'exp' => $expiration->getTimestamp(),
            'username' => $user->getEmail()
        ];
        return $this->jwtManager->createFromPayload($user, $payload);
    }

    public function generateRefreshToken(User $user): string
    {
        $exp = $_ENV['REFRESH_TOKEN_EXPIRATION'] ?? '+1 month';
        $expiration = new DateTime($exp);
        $payload = [
            'type' => self::REFRESH_TOKEN_TYPE,
            'exp' => $expiration->getTimestamp(),
            'username' => $user->getEmail()
        ];
        return $this->jwtManager->createFromPayload($user, $payload);
    }

    public function validateAccessToken(string $token): array
    {
        $payload = $this->validateToken($token);
        if ($payload['type'] !== self::ACCESS_TOKEN_TYPE) {
            throw new InvalidJwtTokenException('Invalid access token - wrong token type');
        }
        return $payload;
    }

    public function validateRefreshToken(string $token): array
    {
        $payload = $this->validateToken($token);
        if ($payload['type'] !== self::REFRESH_TOKEN_TYPE) {
            throw new InvalidJwtTokenException('Invalid refresh token - wrong token type');
        }
        return $payload;
    }

    private function validateToken(string $token): array
    {
        try {
            $payload = $this->jwtManager->parse($token);
            if (!isset($payload['type']) || !in_array($payload['type'], [self::ACCESS_TOKEN_TYPE, self::REFRESH_TOKEN_TYPE])) {
                throw new InvalidJwtTokenException('Invalid token type');
            }
            return $payload;
        } catch (Throwable $e) {
            throw new InvalidJwtTokenException($e->getMessage());
        }
    }
}
