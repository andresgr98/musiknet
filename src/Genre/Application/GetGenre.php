<?php

namespace App\Genre\Application;

use App\Entity\Genre;
use App\Genre\Domain\GenreRepository;

class GetGenre
{
    public function __construct(private readonly GenreRepository $genreRepository) {}

    public function get(int $id): ?Genre
    {
        return $this->genreRepository->findOne($id);
    }
}
