<?php

namespace App\Track\Infrastructure;

use App\Track\Domain\TrackStorageRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrackInMemoryRepository implements TrackStorageRepository
{
    private string $audioDirectory;

    public function __construct()
    {
        $this->audioDirectory = __DIR__ . '/../../../public/tracks';

        if (!is_dir($this->audioDirectory)) {
            mkdir($this->audioDirectory, 0777, true);
        }
    }

    public function create(UploadedFile $trackFile, string $uuid): void
    {
        $trackFile->move($this->audioDirectory, $uuid . '.mp3');
    }

    public function findOne(string $uuid): UploadedFile
    {
        $filePath = $this->audioDirectory . '/' . $uuid . '.mp3';
        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('Track not found');
        }

        return new UploadedFile($filePath, $uuid . '.mp3', 'audio/mpeg', null, true);
    }

    public function delete(string $uuid): void
    {
        $filePath = $this->audioDirectory . '/' . $uuid . '.mp3';

        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('Track not found', null, HttpFoundationResponse::HTTP_NOT_FOUND);
        }
        unlink($filePath);
    }
}
