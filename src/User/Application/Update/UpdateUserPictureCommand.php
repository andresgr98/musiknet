<?php

namespace App\User\Application\Update;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateUserPictureCommand
{
    public function __construct(private readonly UploadedFile $profilePicture, private readonly User $user) {}

    public function file(): UploadedFile
    {
        return $this->profilePicture;
    }

    public function user(): User
    {
        return $this->user;
    }
}
