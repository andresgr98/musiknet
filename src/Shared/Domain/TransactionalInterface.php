<?php

namespace App\Shared\Domain;

interface TransactionalInterface
{
    public function transactional(callable $fn): mixed;
}
