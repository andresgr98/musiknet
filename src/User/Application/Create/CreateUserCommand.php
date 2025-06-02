<?php

namespace App\User\Application\Create;

class CreateUserCommand
{
    public function __construct(
        private readonly string $email,
        private readonly string $password,
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly int $phone,
        private readonly string $location,
        private readonly string $profile_picture_url,
        private readonly string $artistName,
        private readonly int $genderId,
        private readonly array $userGenres,
        private readonly array $userRoles,
        private readonly array $userLanguages,
        private readonly string $trackUrl1,
        private readonly ?string $trackUrl2,
        private readonly ?string $trackUrl3
    ) {}

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function phone(): int
    {
        return $this->phone;
    }

    public function location(): string
    {
        return $this->location;
    }

    public function profilePictureUrl(): string
    {
        return $this->profile_picture_url;
    }

    public function artistName(): string
    {
        return $this->artistName;
    }

    public function genderId(): int
    {
        return $this->genderId;
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

    public function trackUrl1(): string
    {
        return $this->trackUrl1;
    }

    public function trackUrl2(): ?string
    {
        return $this->trackUrl2;
    }

    public function trackUrl3(): ?string
    {
        return $this->trackUrl3;
    }
}
