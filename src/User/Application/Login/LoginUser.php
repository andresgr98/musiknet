<?php

namespace App\User\Application\Login;

use App\Entity\User;
use App\User\Application\Get\GetUser;
use App\User\Domain\Exception\AuthenticationException;
use App\User\Domain\TokenService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginUser
{
    public function __construct(
        private readonly GetUser $getUser,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly TokenService $tokenService
    ) {}

    public function loginByEmail(string $email, string $password): array
    {
        $user = $this->findUserByEmail($email);
        $this->checkPassword($user, $password);
        return $this->createPayload($user);
    }

    private function checkPassword($user, $password)
    {
        if (!$user || !$this->passwordHasher->isPasswordValid($user, $password)) {
            throw new AuthenticationException('Invalid credentials');
        }
    }

    private function findUserByEmail($email): User
    {
        $user = $this->getUser->getByEmail($email);
        if (!$user) {
            throw new AuthenticationException('User not found.');
        }
        return $user;
    }

    private function createPayload(User $user): array
    {
        return [
            'accessToken' => $this->tokenService->generateAccessToken($user),
            'refreshToken' => $this->tokenService->generateRefreshToken($user)
        ];
    }
}
