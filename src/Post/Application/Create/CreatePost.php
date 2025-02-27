<?php

namespace App\Post\Application\Create;

use App\Entity\Post;
use App\Entity\User;
use App\Post\Domain\PostRepository;
use App\Track\Application\Create\CreateTrack;

class CreatePost
{
    public function __construct(private readonly PostRepository $postRepository, private readonly CreateTrack $createTrack) {}

    public function create(string $content, ?string $trackUrl, User $user): Post
    {
        $post = new Post();
        if ($trackUrl) {
            $track = $this->createTrack->create($trackUrl, $user);
            $post->setTrack($track);
        }
        $post->setContent($content);
        $post->setUser($user);
        return $this->postRepository->save($post);
    }
}
