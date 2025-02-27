<?php

namespace App\Controller;

use App\Entity\User;
use App\Post\Application\Create\CreatePostCommand;
use App\Post\Application\Delete\DeletePostCommand;
use App\Post\Application\Get\GetPostsQuery;
use App\Post\Application\Get\GetUserPostsQuery;
use App\Shared\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Security;

class PostController extends AbstractController
{
    public function __construct() {}

    #[Route('/posts', name: 'posts', methods: ['GET'])]
    public function getPostsForUser(
        #[CurrentUser()] User $currentUser,
        QueryBus $queryBus,
        SerializerInterface $serializer
    ): JsonResponse {
        $query = new GetPostsQuery($currentUser);
        $json = $serializer->serialize($queryBus->query($query), 'json', ['groups' => 'posts:feed']);

        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/posts/{postId}', name: 'delete_post', methods: ['DELETE'])]
    public function deletePost(
        #[CurrentUser()] User $currentUser,
        int $postId,
        MessageBusInterface $bus
    ): JsonResponse {
        $command = new DeletePostCommand($postId, $currentUser);
        $bus->dispatch($command);

        return new JsonResponse(null, 204);
    }

    #[Route('/posts/user/{userId}', name: 'user_posts', methods: ['GET'])]
    public function getUserPosts(
        #[CurrentUser()] User $currentUser,
        int $userId,
        QueryBus $queryBus,
        SerializerInterface $serializer
    ): JsonResponse {
        $query = new GetUserPostsQuery($currentUser, $userId);
        $json = $serializer->serialize($queryBus->query($query), 'json', ['groups' => 'posts:feed']);
        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/posts', name: 'create_post', methods: ['POST'])]
    public function createPost(
        #[CurrentUser()] User $currentUser,
        MessageBusInterface $bus,
        Request $request
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $command = new CreatePostCommand(
            $data['content'],
            $data['trackUrl'] ?? null,
            $currentUser
        );
        $bus->dispatch($command);

        return new JsonResponse(["OK"], 201);
    }
}
