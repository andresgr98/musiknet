<?php

namespace App\Genre\Infrastructure;

use App\Entity\Genre;
use App\Genre\Domain\GenreRepository;
use App\Shared\DoctrineRepository;

class GenreMySqlRepository extends DoctrineRepository implements GenreRepository
{
    public function findAll(): array
    {
        return $this->entityManager()->getRepository(Genre::class)->findAll();
    }

    public function findOne(int $id): ?Genre
    {
        return $this->entityManager()->getRepository(Genre::class)->findOneBy(['id' => $id]);
    }
}
