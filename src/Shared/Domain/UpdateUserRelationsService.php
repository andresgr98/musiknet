<?php

namespace App\Shared\Domain;

use App\Entity\User;
use App\User\Domain\UserRepository;

class UpdateUserRelationsService
{
    public function __construct(private readonly UserRepository $userRepository) {}

    public function updateRelation(
        User $user,
        array $items,
        callable $getEntity,
        string $clearMethod,
        string $addMethod,
        string $exceptionClass
    ): User {
        $user->{$clearMethod}();
        foreach ($items as $item) {
            $entity = $getEntity($item["id"]);
            if ($entity === null) {
                throw new $exceptionClass(code: 404);
            }
            $user->{$addMethod}($entity);
        }

        return $this->userRepository->save($user);
    }
}
