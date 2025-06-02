<?php

namespace App\Track\Application\Create;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UploadTrackCommandHandler
{
    public function __construct(private readonly UploadTrack $uploadTrack) {}

    public function __invoke(UploadTrackCommand $command)
    {
        $this->uploadTrack->upload($command->trackFile(), $command->user(), $command->trackTypeId());
    }
}
