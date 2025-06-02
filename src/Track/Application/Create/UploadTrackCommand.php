<?php

namespace App\Track\Application\Create;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadTrackCommand
{

    public function __construct(

        private readonly UploadedFile $trackFile,
        private readonly User $user,
        private readonly int $trackTypeId,
    ) {}

    public function trackFile(): UploadedFile
    {
        return $this->trackFile;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function trackTypeId(): int
    {
        return $this->trackTypeId;
    }
}
