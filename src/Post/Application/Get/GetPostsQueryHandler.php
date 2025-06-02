<?php

namespace App\Post\Application\Get;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetPostsQueryHandler
{
    public function __construct(private readonly GetPosts $getPosts) {}

    public function __invoke(GetPostsQuery $query): array
    {
        return $this->getPosts->getPostsForUser($query->user(), $query->page(), $query->limit());
    }
}
