<?php

namespace App\User\Application\Update;

class UpdateUserCommand
{
    public function __construct(
        private readonly ?string $artistName = null,
        private readonly ?string $firstName = null,
        private readonly ?string $lastName = null,
        private readonly ?string $phone = null,
        private readonly ?string $location = null,
        private readonly ?string $profilePictureUrl = null,
        private readonly ?array $userGenres = null,
        private readonly ?array $userRoles = null,
        private readonly ?array $userLanguages = null
    ) {}

    public function artistName(): ?string
    {
        return $this->artistName;
    }
    public function firstName(): ?string
    {
        return $this->firstName;
    }
    public function lastName(): ?string
    {
        return $this->lastName;
    }
    public function phone(): ?string
    {
        return $this->phone;
    }
    public function location(): ?string
    {
        return $this->location;
    }
    public function profilePictureUrl(): ?string
    {
        return $this->profilePictureUrl;
    }
    public function userGenres(): ?array
    {
        return $this->userGenres;
    }
    public function userRoles(): ?array
    {
        return $this->userRoles;
    }
    public function userLanguages(): ?array
    {
        return $this->userLanguages;
    }
}
