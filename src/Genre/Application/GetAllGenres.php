<?php

namespace App\Genre\Application;

use App\Genre\Domain\GenreRepository;

class GetAllGenres
{
    public function __construct(private readonly GenreRepository $languageRepository) {}

    public function get(): array
    {
        return $this->languageRepository->findAll();
    }
}
