<?php

namespace App\Post\Application\Create;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreatePostCommand
{

    public function __construct(
        private readonly string $content,
        private readonly ?UploadedFile $trackFile,
        private readonly User $user
    ) {}

    public function content(): string
    {
        return $this->content;
    }

    public function trackFile(): ?UploadedFile
    {
        return $this->trackFile;
    }

    public function user(): User
    {
        return $this->user;
    }
}
