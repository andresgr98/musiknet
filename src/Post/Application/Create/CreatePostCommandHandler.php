<?php

namespace App\Post\Application\Create;

use App\Post\Application\Create\CreatePost;
use App\Post\Application\Create\CreatePostCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreatePostCommandHandler
{
    public function __construct(private readonly CreatePost $createPost) {}

    public function __invoke(CreatePostCommand $command)
    {
        $this->createPost->create($command->content(), $command->trackFile(), $command->user());
    }
}
