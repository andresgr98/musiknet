<?php

namespace App\Controller;

use App\Entity\User;
use App\Shared\Domain\AllowedAudioFileFormats;
use App\Shared\QueryBus;
use App\Track\Application\Create\UploadTrackCommand;
use App\Track\Application\Find\FindTrackQuery;
use App\Track\Application\Update\ReplaceTrackCommand;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class TrackController extends AbstractController
{
    public function __construct() {}

    #[Route('/tracks/{uuid}', name: 'get_track', methods: ['GET'])]
    public function findTrack(
        string $uuid,
        QueryBus $bus
    ): BinaryFileResponse {

        $query = new FindTrackQuery($uuid);
        $mp3 = $bus->query($query);
        $response = new BinaryFileResponse($mp3->getPathname());
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE, 'track.mp3');
        $response->headers->set('Content-Type', 'audio/mpeg');

        return $response;
    }

    #[Route('/tracks', name: 'upload_track', methods: ['POST'])]
    public function uploadTrack(
        #[CurrentUser] ?User $user,
        MessageBusInterface $bus,
        Request $request
    ): JsonResponse {
        $file = $request->files->get('file');
        $trackTypeId = $request->request->get('trackTypeId');

        if (!$file instanceof UploadedFile) {
            throw new InvalidArgumentException('No file uploaded.', Response::HTTP_BAD_REQUEST);
        }

        if (!$trackTypeId) {
            throw new InvalidArgumentException('Track type ID is required.', Response::HTTP_BAD_REQUEST);
        }

        if (!AllowedAudioFileFormats::isValidFormat($file->getClientOriginalExtension())) {
            throw new InvalidArgumentException('Invalid audio file format.', Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        }

        $command = new UploadTrackCommand($file, $user, $trackTypeId);
        $bus->dispatch($command);

        return new JsonResponse(['OK'], Response::HTTP_CREATED);
    }

    #[Route('/tracks/{uuid}', name: 'replace_track', methods: ['POST'])]
    public function replaceProfileTrack(
        string $uuid,
        #[CurrentUser] ?User $user,
        MessageBusInterface $bus,
        Request $request
    ) {
        $file = $request->files->get('file');

        if (!$file) {
            throw new InvalidArgumentException('No file uploaded.', Response::HTTP_BAD_REQUEST);
        }

        if (!AllowedAudioFileFormats::isValidFormat($file->getClientOriginalExtension())) {
            throw new InvalidArgumentException('Invalid audio file format.', Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        }

        $command = new ReplaceTrackCommand($file, $uuid, $user);
        $bus->dispatch($command);

        return new JsonResponse(['OK'], Response::HTTP_CREATED);
    }
}
