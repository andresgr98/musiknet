<?php

namespace App\Track\Application\Update;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ReplaceTrackCommandHandler
{
    public function __construct(private readonly ReplaceProfileTrack $replaceProfileTrack) {}

    public function __invoke(ReplaceTrackCommand $command)
    {
        $this->replaceProfileTrack->replace($command->trackFile(), $command->uuid(), $command->user());
    }
}
