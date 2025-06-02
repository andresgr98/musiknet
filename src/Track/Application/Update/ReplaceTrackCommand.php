<?php

namespace App\Track\Application\Update;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ReplaceTrackCommand
{

    public function __construct(

        private readonly UploadedFile $trackFile,
        private string $uuid,
        private readonly User $user,
    ) {}

    public function trackFile(): UploadedFile
    {
        return $this->trackFile;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function user(): User
    {
        return $this->user;
    }
}
