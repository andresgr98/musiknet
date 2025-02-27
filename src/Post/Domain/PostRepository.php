<?php

namespace App\Post\Domain;

use App\Entity\Post;

interface PostRepository
{
    public function findOne(int $id): ?Post;

    public function findFeedForUser(int $currentUserId): array;

    public function findUserPosts(int $userId): array;

    public function save(Post $post): Post;

    public function delete(Post $post): void;
}
