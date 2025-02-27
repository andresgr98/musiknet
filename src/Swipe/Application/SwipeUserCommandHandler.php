<?php

namespace App\Swipe\Application;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SwipeUserCommandHandler
{
    public function __construct(private readonly SwipeUser $swipeUser) {}

    public function __invoke(SwipeUserCommand $command): void
    {
        $this->swipeUser->swipeUser($command->user(), $command->swipedUserId(), $command->liked());
    }
}
