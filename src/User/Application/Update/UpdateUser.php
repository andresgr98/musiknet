<?php

namespace App\User\Application\Update;

use App\User\Domain\UserRepository;
use App\Entity\User;
use App\Genre\Application\GetGenre;
use App\Genre\Domain\Exception\GenreException;
use App\Language\Domain\Exception\LanguageException;
use App\Role\Application\GetRole;
use App\Role\Domain\Exception\RoleException;
use App\User\Domain\Exception\AuthenticationException;
use App\Language\Application\GetLanguage;
use App\Shared\Domain\UpdateUserRelationsService;
use Symfony\Bundle\SecurityBundle\Security;

class UpdateUser
{
    public function __construct(
        private readonly Security $security,
        private readonly UserRepository $userRepository,
        private readonly GetRole $getRole,
        private readonly GetGenre $getGenre,
        private readonly GetLanguage $getLanguage,
        private readonly UpdateUserRelationsService $updateService
    ) {}

    public function update(
        ?string $artistName,
        ?string $firstName,
        ?string $lastName,
        ?string $phone,
        ?string $location,
        ?string $profilePictureUrl,
        ?array $userGenres,
        ?array $userRoles,
        ?array $userLanguages
    ): void {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new AuthenticationException('User is not logged in');
        }

        if ($artistName !== null) {
            $user->setArtistName($artistName);
        }

        if ($firstName !== null) {
            $user->setFirstName($firstName);
        }

        if ($lastName !== null) {
            $user->setLastName($lastName);
        }

        if ($phone !== null) {
            $user->setPhone($phone);
        }

        if ($location !== null) {
            $user->setLocation($location);
        }

        if ($profilePictureUrl !== null) {
            $user->setProfilePictureUrl($profilePictureUrl);
        }

        if (!empty($userGenres)) {
            $user = $this->updateGenres($user, $userGenres);
        }

        if (!empty($userRoles)) {
            $user = $this->updateRoles($user, $userRoles);
        }

        if (!empty($userLanguages)) {
            $user = $this->updateUserLanguages($user, $userLanguages);
        }

        $user->setUpdatedAt(new \DateTimeImmutable());

        $this->userRepository->save($user);
    }

    private function updateGenres(User $user, array $userGenres): User
    {
        return $this->updateService->updateRelation(
            $user,
            $userGenres,
            fn($id) => $this->getGenre->get($id),
            'clearUserGenres',
            'addUserGenre',
            GenreException::class
        );
    }

    private function updateRoles(User $user, array $userRoles): User
    {
        return $this->updateService->updateRelation(
            $user,
            $userRoles,
            fn($id) => $this->getRole->get($id),
            'clearUserRoles',
            'addUserRole',
            RoleException::class
        );
    }

    private function updateUserLanguages(User $user, array $userLanguages): User
    {
        return $this->updateService->updateRelation(
            $user,
            $userLanguages,
            fn($id) => $this->getLanguage->get($id),
            'clearUserLanguages',
            'addUserLanguage',
            LanguageException::class
        );
    }
}
