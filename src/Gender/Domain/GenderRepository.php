<?php

namespace App\Gender\Domain;

use App\Entity\Gender;

interface GenderRepository
{
    public function findOne(int $id): Gender;
}
