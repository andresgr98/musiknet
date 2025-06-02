<?php

namespace App\User\Application\Update;

use App\Entity\User;
use App\User\Domain\UserRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;
use Throwable;

class UpdateUserPicture
{
    private string $audioDirectory = __DIR__ . '/../../../../public/images';

    public function __construct(private readonly UserRepository $userRepository)
    {
        if (!is_dir($this->audioDirectory)) {
            mkdir($this->audioDirectory, 0777, true);
        }
    }

    public function update(UploadedFile $pictureFile, User $user): void
    {
        try {
            $uuid = Uuid::v4()->toString();
            $this->deleteOldPictureIfExists($user);
            $this->createLocalFile($pictureFile, $uuid);
            $user->setProfilePictureUuid($uuid);
            $this->userRepository->save($user);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    private function createLocalFile(UploadedFile $pictureFile, string $uuid): void
    {
        $pictureFile->move($this->audioDirectory, $uuid . '.' . $pictureFile->guessExtension());
    }

    private function deleteOldPictureIfExists(User $user): void
    {
        $oldPictureUuid = $user->getProfilePictureUuid();
        if ($oldPictureUuid) {
            $oldPicturePath = $this->audioDirectory . '/' . $oldPictureUuid . '.' . 'jpg';
            if (file_exists($oldPicturePath)) {
                unlink($oldPicturePath);
            }
        }
    }
}
