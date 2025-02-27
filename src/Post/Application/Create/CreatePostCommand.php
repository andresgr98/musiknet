<?php

namespace App\Post\Application\Create;

use App\Entity\User;

class CreatePostCommand
{

    public function __construct(
        private readonly string $content,
        private readonly ?string $trackUrl,
        private readonly User $user
    ) {}

    public function content(): string
    {
        return $this->content;
    }

    public function trackUrl(): ?string
    {
        return $this->trackUrl;
    }

    public function user(): User
    {
        return $this->user;
    }
}
