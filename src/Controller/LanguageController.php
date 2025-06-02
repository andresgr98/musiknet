<?php

namespace App\Controller;

use App\Language\Application\GetAllLanguages;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

class LanguageController extends AbstractController
{
    public function __construct() {}

    #[Route('/languages', name: 'get_languages', methods: ['GET'])]
    public function getAllLanguages(
        GetAllLanguages $getAllLanguages,
        SerializerInterface $serializer
    ): JsonResponse {
        $json = $serializer->serialize($getAllLanguages->get(), 'json', ['groups' => 'language:get']);
        return new JsonResponse($json, 200, [], true);
    }
}
