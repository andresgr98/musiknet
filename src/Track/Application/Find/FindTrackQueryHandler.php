<?php

namespace App\Track\Application\Find;

use App\Track\Application\Find\FindTrack;
use SplFileInfo;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class FindTrackQueryHandler
{
    public function __construct(private readonly FindTrack $findTrack) {}

    public function __invoke(FindTrackQuery $command): ?SplFileInfo
    {
        return $this->findTrack->find($command->getUuid());
    }
}
