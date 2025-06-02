<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface, PasswordUpgraderInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["user:swiper", "posts:feed"])]
    private int $id;

    #[ORM\Column(name: "artist_name", type: "string", length: 255)]
    #[Groups(["user:swiper", "posts:feed"])]
    private string $artistName;


    #[ORM\Column(name: "first_name", type: "string", length: 255)]
    #[Groups(["user:swiper", "posts:feed"])]
    private string $firstName;


    #[ORM\Column(name: "last_name", type: "string", length: 255)]
    #[Groups(["user:swiper", "posts:feed"])]
    private string $lastName;


    #[ORM\Column(type: "string", length: 255, unique: true)]
    #[Groups(["user:swiper"])]
    private string $email;

    #[ORM\Column(type: "string", length: 255)]
    #[Ignore]
    private string $password;

    #[ORM\Column(type: "string", length: 255)]
    private string $googleId;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $phone = null;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $location = null;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Groups(["user:swiper", "posts:feed"])]
    private ?string $profilePictureUuid = null;


    #[ORM\Column(type: "datetime_immutable", options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTimeImmutable $createdAt;


    #[ORM\Column(type: "datetime_immutable", nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;


    #[ORM\ManyToOne(targetEntity: Gender::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(["user:swiper"])]
    private ?Gender $gender = null;

    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: "users")]
    #[ORM\JoinTable(name: "user_genre")]
    #[Groups(["user:swiper"])]
    private Collection $userGenres;

    #[ORM\ManyToMany(targetEntity: Language::class, inversedBy: "users")]
    #[ORM\JoinTable(name: "user_language")]
    #[Groups(["user:swiper"])]
    private Collection $userLanguages;

    #[ORM\ManyToMany(targetEntity: Role::class, inversedBy: "users")]
    #[ORM\JoinTable(name: "user_role")]
    #[Groups(["user:swiper"])]
    private Collection $userRoles;

    #[ORM\ManyToMany(targetEntity: Role::class, inversedBy: "users")]
    #[ORM\JoinTable(name: "search_user_role")]
    #[Groups(["user:swiper"])]
    private Collection $searchRoles;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: Swipe::class)]
    #[Ignore]
    private Collection $swipes;

    #[ORM\OneToMany(mappedBy: "swipedUser", targetEntity: Swipe::class)]
    #[Ignore]
    private $receivedSwipes;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: Post::class)]
    #[Ignore]
    private Collection $posts;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Track::class)]
    private Collection $tracks;

    #[Ignore]
    private array $authRoles = [];

    public function __construct()
    {
        $this->userGenres = new ArrayCollection();
        $this->userLanguages = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
        $this->swipes = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->searchRoles = new ArrayCollection();
        $this->receivedSwipes = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getGoogleId(): string
    {
        return $this->googleId;
    }

    public function setGoogleId(string $googleId): self
    {
        $this->googleId = $googleId;
        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getProfilePictureUuid(): ?string
    {
        return $this->profilePictureUuid;
    }

    public function setProfilePictureUuid(?string $profilePictureUuid): self
    {
        $this->profilePictureUuid = $profilePictureUuid;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    #[Groups(["user:swiper"])]
    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    #[Groups(["user:swiper"])]
    public function getUserLanguages(): Collection
    {
        return $this->userLanguages;
    }

    public function addUserLanguage(Language $language): self
    {
        if (!$this->userLanguages->contains($language)) {
            $this->userLanguages[] = $language;
        }

        return $this;
    }

    public function clearUserLanguages()
    {
        $this->userLanguages->clear();
    }

    public function __toString()
    {
        return "
        
        ";
    }

    public function getArtistName(): ?string
    {
        return $this->artistName;
    }

    public function setArtistName(string $artistName): static
    {
        $this->artistName = $artistName;

        return $this;
    }

    #[Groups(["user:swiper"])]
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(Role $role): self
    {
        if (!$this->userRoles->contains($role)) {
            $this->userRoles[] = $role;
        }

        return $this;
    }

    public function clearUserRoles()
    {
        $this->userRoles->clear();
    }

    #[Groups(["user:swiper"])]
    public function getSearchRoles(): Collection
    {
        return $this->searchRoles;
    }

    #[Groups(["user:swiper"])]
    public function getUserGenres(): Collection
    {
        return $this->userGenres;
    }

    public function addUserGenre(Genre $genre): self
    {
        if (!$this->userGenres->contains($genre)) {
            $this->userGenres[] = $genre;
        }

        return $this;
    }

    #[Groups(["user:swiper"])]
    public function getTracks(): Collection
    {
        return $this->tracks->filter(function ($track) {
            return in_array($track->getType()->getId(), [TrackType::TYPE_MAIN, TrackType::TYPE_PROFILE]);
        });
    }

    public function clearUserGenres()
    {
        $this->userGenres->clear();
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    #[Ignore]
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function setRoles(array $authRoles): void
    {
        $this->authRoles = $authRoles;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void {}

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void {}
}
