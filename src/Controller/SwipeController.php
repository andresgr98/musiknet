<?php

namespace App\Controller;

use App\Entity\User;
use App\Swipe\Application\SwipeUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class SwipeController extends AbstractController
{
    public function __construct() {}

    #[Route('/swipe', name: 'swipe', methods: ['POST'])]
    public function swipeUser(
        #[CurrentUser()] User $currentUser,
        Request $request,
        MessageBusInterface $bus
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $command = new SwipeUserCommand($currentUser, $data["swipedUserId"], $data["liked"]);
        $bus->dispatch($command);

        return $this->json(['OK'], 201);
    }
}
