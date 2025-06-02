<?php

namespace App\Post\Application\Create;

use App\Entity\Post;
use App\Entity\TrackType;
use App\Entity\User;
use App\Post\Domain\PostRepository;
use App\Track\Application\Create\UploadTrack;
use App\TrackType\Application\Find\FindTrackType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreatePost
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly UploadTrack $uploadTrack,
        private readonly FindTrackType $findTrackType,
    ) {}

    public function create(string $content, ?UploadedFile $trackFile, User $user): Post
    {
        $post = new Post();
        if ($trackFile) {
            $track = $this->uploadTrack->upload($trackFile, $user, TrackType::TYPE_POST);
            $post->setTrack($track);
        }
        $post->setContent($content);
        $post->setUser($user);
        return $this->postRepository->save($post);
    }
}
