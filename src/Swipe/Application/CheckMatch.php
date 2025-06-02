<?php

namespace App\Swipe\Application;

use App\Entity\User;
use App\Swipe\Domain\SwipeRepository;

class CheckMatch
{
    public function __construct(
        private readonly SwipeRepository $swipeRepository,
    ) {}

    public function check(
        User $user1,
        User $user2,
    ): bool {
        $idUser1 = $user1->getId();
        $idUser2 = $user2->getId();
        $swipe1 = $this->swipeRepository->findOneBySwipeUsers($idUser1, $idUser2);
        $swipe2 = $this->swipeRepository->findOneBySwipeUsers($idUser2, $idUser1);
        if (($swipe1 && $swipe2) && ($swipe1->isLiked() && $swipe2->isLiked())) {
            return true;
        }
        return false;
    }
}
