<?php

namespace App\Controller;

use App\Entity\User;
use App\Post\Application\Create\CreatePostCommand;
use App\Post\Application\Delete\DeletePostCommand;
use App\Post\Application\Get\GetPostsQuery;
use App\Post\Application\Get\GetUserPostsQuery;
use App\Shared\Domain\AllowedAudioFileFormats;
use App\Shared\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PostController extends AbstractController
{
    public function __construct() {}

    #[Route('/posts', name: 'posts', methods: ['GET'])]
    public function getPostsForUser(
        #[CurrentUser()] User $currentUser,
        Request $request,
        QueryBus $queryBus,
        SerializerInterface $serializer,
        NormalizerInterface $normalizer
    ): JsonResponse {
        $page = (int) $request->query->get('page', 1);
        $limit = (int) $request->query->get('limit', 50);

        $query = new GetPostsQuery($currentUser, $page, $limit);
        $data = $queryBus->query($query);
        $json = $serializer->serialize($data['data'], 'json', ['groups' => 'posts:feed']);
        $paginatedResponse = $normalizer->normalize(json_decode($json, true), null, [
            'pagination' => true,
            'totalRecords' => $data['totalRecords'],
            'page' => $page,
            'limit' => $limit,
        ]);

        return new JsonResponse($paginatedResponse, 200, [], false);
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
        SerializerInterface $serializer,
        NormalizerInterface $normalizer,
        Request $request
    ): JsonResponse {
        $page = (int) $request->query->get('page', 1);
        $limit = (int) $request->query->get('limit', 50);
        $query = new GetUserPostsQuery($currentUser, $userId, $page, $limit);
        $data = $queryBus->query($query);
        $json = $serializer->serialize($data['data'], 'json', ['groups' => 'posts:feed']);
        $paginatedResponse = $normalizer->normalize(json_decode($json, true), null, [
            'pagination' => true,
            'totalRecords' => $data['totalRecords'],
            'page' => $page,
            'limit' => $limit,
        ]);
        return new JsonResponse($paginatedResponse, 200, [], false);
    }

    #[Route('/posts', name: 'create_post', methods: ['POST'])]
    public function createPost(
        #[CurrentUser()] User $currentUser,
        MessageBusInterface $bus,
        Request $request
    ): JsonResponse {
        $file = $request->files->get('file');
        $content = $request->request->get('content');

        if ($file && !AllowedAudioFileFormats::isValidFormat($file->getClientOriginalExtension())) {
            return new JsonResponse(['error' => 'Only MP3 files are allowed'], Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        }

        $command = new CreatePostCommand(
            $content,
            $file,
            $currentUser
        );
        $bus->dispatch($command);

        return new JsonResponse(["OK"], 201);
    }
}
