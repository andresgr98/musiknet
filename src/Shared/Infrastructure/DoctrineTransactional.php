<?php

namespace App\Shared\Infrastructure;

use App\Shared\Domain\TransactionalInterface;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class DoctrineTransactional implements TransactionalInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function transactional(callable $fn): mixed
    {
        $this->entityManager->beginTransaction();

        try {
            $result = $fn();
            $this->entityManager->commit();
            return $result;
        } catch (Throwable $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
}
