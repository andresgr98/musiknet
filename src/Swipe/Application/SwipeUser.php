<?php

namespace App\Swipe\Application;

use App\Entity\Swipe;
use App\Entity\User;
use App\Swipe\Domain\Exception\SwipeException;
use App\Swipe\Domain\SwipeRepository;
use App\User\Application\Get\GetUser;
use App\User\Domain\Exception\UserException;
use DateTimeImmutable;

class SwipeUser
{
    public function __construct(
        private readonly SwipeRepository $swipeRepository,
        private readonly GetUser $getUser
    ) {}

    public function swipeUser(User $currentUser, int $swipedUserId, bool $liked): void
    {
        $swipedUser = $this->getSwipedUser($swipedUserId, $currentUser);
        $existingSwipe = $this->getExistingSwipe($currentUser->getId(), $swipedUserId);

        if ($existingSwipe) {
            $this->handleExistingSwipe($existingSwipe, $liked);
        } else {
            $this->createNewSwipe($currentUser, $swipedUser, $liked);
        }
    }

    private function getSwipedUser(int $swipedUserId, User $currentUser): ?User
    {
        $swipedUser = $this->getUser->get($swipedUserId);

        if (!$swipedUser || $swipedUser->getId() === $currentUser->getId()) {
            throw new UserException('Invalid swiped user', 400);
        }

        return $swipedUser;
    }

    private function getExistingSwipe(int $currentUserId, int $swipedUserId): ?Swipe
    {
        return $this->swipeRepository->findOneBySwipeUsers($currentUserId, $swipedUserId);
    }

    private function handleExistingSwipe(Swipe $existingSwipe, bool $liked): void
    {
        if ($existingSwipe->isLiked() !== $liked) {
            $existingSwipe->setLiked($liked);
        }

        $existingSwipe->setUpdatedAt(new DateTimeImmutable());
        $this->swipeRepository->save($existingSwipe);

        $this->swipeRepository->save($existingSwipe);
    }

    private function createNewSwipe(User $currentUser, User $swipedUser, bool $liked): void
    {
        $newSwipe = new Swipe();
        $newSwipe->setUser($currentUser);
        $newSwipe->setSwipedUser($swipedUser);
        $newSwipe->setLiked($liked);

        $this->swipeRepository->save($newSwipe);
    }
}
