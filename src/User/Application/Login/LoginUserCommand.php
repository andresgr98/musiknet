<?php

namespace App\User\Application\Login;

class LoginUserCommand
{
    public function __construct(
        private readonly string $email,
        private readonly string $password
    ) {}

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
