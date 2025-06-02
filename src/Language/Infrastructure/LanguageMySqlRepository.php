<?php

namespace App\Language\Infrastructure;

use App\Entity\Language;
use App\Language\Domain\LanguageRepository;
use App\Shared\DoctrineRepository;

class LanguageMySqlRepository extends DoctrineRepository implements LanguageRepository
{
    public function findAll(): array
    {
        return $this->entityManager()->getRepository(Language::class)->findAll();
    }

    public function findOne(int $id): ?Language
    {
        return $this->entityManager()->getRepository(Language::class)->findOneBy(['id' => $id]);
    }
}
