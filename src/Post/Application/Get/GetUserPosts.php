<?php

namespace App\Post\Application\Get;

use App\Entity\User;
use App\Post\Domain\PostRepository;
use App\Swipe\Application\CheckMatch;
use App\User\Application\Get\GetUser;
use App\User\Domain\Exception\UserException;

class GetUserPosts
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly CheckMatch $checkMatch,
        private readonly GetUser $getUser
    ) {}

    public function getPostsByUser(User $currentUser, int $userId, int $page, int $limit): array
    {
        $user = $this->getUser->get($userId);
        if (!$user) {
            throw new UserException('User not found', 404);
        }

        if (!$this->checkMatch($currentUser, $user)) {
            throw new UserException('Users are not matched', 403);
        }

        return [
            "data" => $this->postRepository->findUserPosts($user->getId(), $page, $limit),
            "totalRecords" => $this->postRepository->countUserPosts($user->getId())
        ];
    }

    private function checkMatch(User $user1, User $user2): bool
    {
        return $this->checkMatch->check($user1, $user2) || $user2->getId() == $user1->getId();
    }
}
