<?php

namespace App\Language\Application;

use App\Language\Domain\LanguageRepository;

class GetAllLanguages
{
    public function __construct(private readonly LanguageRepository $languageRepository) {}

    public function get(): array
    {
        return $this->languageRepository->findAll();
    }
}
