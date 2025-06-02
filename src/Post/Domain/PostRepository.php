<?php

namespace App\Post\Domain;

use App\Entity\Post;

interface PostRepository
{
    public function findOne(int $id): ?Post;

    public function findFeedForUser(int $currentUserId, int $page, int $limit): array;

    public function countFeedForUser(int $currentUserId): int;

    public function findUserPosts(int $userId, int $page, int $limit): array;

    public function countUserPosts(int $userId): int;

    public function save(Post $post): Post;

    public function delete(Post $post): void;
}
