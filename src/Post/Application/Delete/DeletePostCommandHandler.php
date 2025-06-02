<?php

namespace App\Post\Application\Delete;

use App\Post\Application\Delete\DeletePost;
use App\Post\Application\Delete\DeletePostCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeletePostCommandHandler
{
    public function __construct(private readonly DeletePost $deletePost) {}

    public function __invoke(DeletePostCommand $command)
    {
        $this->deletePost->create($command->postId(), $command->user());
    }
}
