<?php

namespace App\Gender\Application\Get;

use App\Gender\Domain\GenderRepository;

class GetGender
{
    public function __construct(private readonly GenderRepository $genderRepository) {}

    public function get(int $genderId)
    {
        return $this->genderRepository->findOne($genderId);
    }
}
