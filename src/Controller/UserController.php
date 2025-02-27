<?php

namespace App\Controller;

use App\Entity\User;
use App\Shared\QueryBus;
use App\User\Application\Get\GetUserQuery;
use App\User\Application\Get\GetUsersForSwiperQuery;
use App\User\Application\Update\UpdateUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Security;

class UserController extends AbstractController
{
    #[Route('/users/me', methods: ['GET'], name: 'get_current_user')]
    public function getCurrentUser(
        #[CurrentUser] User $currentUser,
        SerializerInterface $serializer
    ): Response {
        $json = $serializer->serialize($currentUser, 'json');
        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/users/edit', methods: ['PUT'], name: 'edit_user')]
    public function editUser(
        Request $request,
        MessageBusInterface $bus
    ): Response {
        $data = json_decode($request->getContent(), true);
        $command = new UpdateUserCommand(
            $data['artistName'],
            $data['firstName'],
            $data['lastName'],
            $data['phone'],
            $data['location'],
            $data['profilePictureUrl'],
            $data['userGenres'] ?? null,
            $data['userRoles'] ?? null,
            $data['userLanguages'] ?? null
        );
        $bus->dispatch($command);

        return new JsonResponse(['message' => 'OK'], 201);
    }
    #[Route('/users/swiper', methods: ['GET'], name: 'get_users_swiper')]
    public function getUsersSwiper(
        #[CurrentUser] User $currentUser,
        QueryBus $queryBus,
        SerializerInterface $serializer
    ): Response {
        $query = new GetUsersForSwiperQuery($currentUser->getId());
        $users = $queryBus->query($query);
        $json = $serializer->serialize($users, 'json', ['groups' => 'user:swiper']);
        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/users/{id}', methods: ['GET'], name: 'get_user')]
    public function findUser(
        int $id,
        QueryBus $queryBus,
        SerializerInterface $serializer
    ): Response {
        $query = new GetUserQuery($id);
        $user = $queryBus->query($query);
        $json = $serializer->serialize($user, 'json');
        return new JsonResponse($json, 200, [], true);
    }
}
