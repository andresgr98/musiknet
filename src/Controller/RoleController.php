<?php

namespace App\Controller;

use App\Role\Application\GetAllRoles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RoleController extends AbstractController
{
    public function __construct(private readonly GetAllRoles $getAllRoles) {}

    #[Route('/roles', name: 'get_roles', methods: ['GET'])]
    public function getAllRoles(
        SerializerInterface $serializer
    ): JsonResponse {
        $json = $serializer->serialize($this->getAllRoles->get(), 'json', ['groups' => 'role:get']);
        return new JsonResponse($json, 200, [], true);
    }
}
