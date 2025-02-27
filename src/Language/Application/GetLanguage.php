<?php

namespace App\Language\Application;

use App\Entity\Language;
use App\Language\Domain\LanguageRepository;

class GetLanguage
{
    public function __construct(private readonly LanguageRepository $languageRepository) {}

    public function get(int $id): ?Language
    {
        return $this->languageRepository->findOne($id);
    }
}
