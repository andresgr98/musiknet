<?php

namespace App\Post\Application\Get;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetUserPostsQueryHandler
{
    public function __construct(private readonly GetUserPosts $getUserPosts) {}

    public function __invoke(GetUserPostsQuery $query): array
    {
        return $this->getUserPosts->getPostsByUser($query->currentUser(), $query->userId(), $query->page(), $query->limit());
    }
}
