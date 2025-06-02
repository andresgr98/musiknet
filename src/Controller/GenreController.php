<?php

namespace App\Controller;

use App\Genre\Application\GetAllGenres;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Security;

class GenreController extends AbstractController
{
    public function __construct() {}

    #[Route('/genres', name: 'get_genres', methods: ['GET'])]
    public function getAllGenres(
        GetAllGenres $getAllGenres,
        SerializerInterface $serializer
    ): JsonResponse {
        $json = $serializer->serialize($getAllGenres->get(), 'json', ['groups' => 'genre:get']);
        return new JsonResponse($json, 200, [], true);
    }
}
