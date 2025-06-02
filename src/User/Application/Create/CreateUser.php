<?php

namespace App\User\Application\Create;

use App\Entity\User;
use App\Gender\Application\Get\GetGender;
use App\Genre\Application\GetGenre;
use App\Genre\Domain\Exception\GenreException;
use App\Language\Application\GetLanguage;
use App\Language\Domain\Exception\LanguageException;
use App\Role\Application\GetRole;
use App\Role\Domain\Exception\RoleException;
use App\Shared\Domain\UpdateUserRelationsService;
use App\Track\Application\Create\CreateTrack;
use App\User\Domain\Exception\UserException;
use App\User\Domain\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUser
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly GetGender $getGender,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UpdateUserRelationsService $updateService,
        private readonly GetGenre $getGenre,
        private readonly GetRole $getRole,
        private readonly GetLanguage $getLanguage,
        private readonly CreateTrack $createTrack
    ) {}

    public function create(
        string $email,
        string $password,
        string $firstName,
        string $lastName,
        int $phone,
        string $location,
        string $profilePictureUrl,
        string $artistName,
        int $genderId,
        array $userGenres,
        array $userRoles,
        array $userLanguages,
        string $trackUrl1,
        ?string $trackUrl2,
        ?string $trackUrl3
    ): User {

        $gender = $this->getGender->get($genderId);

        if (!$gender) {
            throw new UserException("Incorrect gender provided");
        }

        $user = new User();
        $user->setEmail($email)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setPhone($phone)
            ->setLocation($location)
            ->setProfilePictureUrl($profilePictureUrl)
            ->setArtistName($artistName)
            ->setGoogleId("aaabbbccc1234")
            ->setGender($gender);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);

        $user->setPassword($hashedPassword);

        $user = $this->userRepository->save($user);
        $user = $this->updateGenres($user, $userGenres);
        $user = $this->updateRoles($user, $userRoles);
        $user = $this->updateUserLanguages($user, $userLanguages);

        $this->createTrack($user, $trackUrl1, 1);

        if ($trackUrl2) {
            $this->createTrack($user, $trackUrl2, 2);
        }

        if ($trackUrl3) {
            $this->createTrack($user, $trackUrl3, 3);
        }

        return $user;
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

    private function createTrack(User $user, string $trackUrl, int $featuredOrder): void
    {
        $this->createTrack->create($trackUrl, $user, $featuredOrder);
    }
}
