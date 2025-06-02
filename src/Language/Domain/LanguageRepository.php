<?php

namespace App\Language\Domain;

use App\Entity\Language;

interface LanguageRepository
{
    public function findOne(int $id): ?Language;

    public function findAll(): array;
}
