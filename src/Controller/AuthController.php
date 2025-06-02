<?php

namespace App\Controller;

use App\User\Application\Create\CreateUserCommand;
use App\User\Application\Login\LoginUserCommand;
use App\User\Application\RefreshToken\RefreshTokenCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    #[Route('/auth/register', methods: ['POST'], name: 'auth_register_email')]
    public function registerUserByEmail(
        Request $request,
        MessageBusInterface $bus
    ): JsonResponse {
        $request = json_decode($request->getContent(), true);

        $command = new CreateUserCommand(
            $request['email'],
            $request['password'],
            $request['firstName'],
            $request['lastName'],
            $request['phone'],
            $request['location'],
            $request['profilePictureUrl'],
            $request['artistName'],
            $request['genderId'],
            $request['userGenres'],
            $request['userRoles'],
            $request['userLanguages'],
            $request['trackUrl1'],
            $request['trackUrl2'] ?? null,
            $request['trackUrl3'] ?? null
        );
        $bus->dispatch($command);

        return $this->json(['OK'], 201);
    }
    #[Route('/auth/login', methods: ['POST'], name: 'auth_login_email')]
    public function loginByEmail(
        Request $request,
        MessageBusInterface $bus
    ): Response {
        $data = json_decode($request->getContent(), true);
        $command = new LoginUserCommand($data["email"], $data["password"]);
        $payload = $bus->dispatch($command)->last(HandledStamp::class)?->getResult();
        return $this->json($payload);
    }

    #[Route('/auth/refresh', methods: ['POST'], name: 'auth_refresh_token')]
    public function refreshToken(
        Request $request,
        MessageBusInterface $bus
    ): Response {
        $data = json_decode($request->getContent(), true);
        $command = new RefreshTokenCommand($data['refreshToken']);
        $payload = $bus->dispatch($command)->last(HandledStamp::class)?->getResult();

        return $this->json(["accessToken" => $payload]);
    }
}
