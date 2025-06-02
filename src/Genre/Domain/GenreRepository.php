<?php

namespace App\Genre\Domain;

use App\Entity\Genre;

interface GenreRepository
{
    public function findOne(int $id): ?Genre;

    public function findAll(): array;
}
