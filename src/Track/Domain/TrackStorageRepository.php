<?php

namespace App\Track\Domain;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface TrackStorageRepository
{
    public function create(UploadedFile $trackFile, string $uuid): void;
    public function findOne(string $uuid): ?UploadedFile;
    public function delete(string $uuid): void;
}
