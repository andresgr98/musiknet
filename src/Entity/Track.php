<?php

namespace App\Entity;

use App\Repository\TrackRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: TrackRepository::class)]
class Track
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['posts:feed', 'user:swiper'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tracks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private User $user;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['posts:feed', 'user:swiper'])]
    private string $uuid;

    #[ORM\Column]
    #[Groups(['posts:feed', 'user:swiper'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(targetEntity: TrackType::class, inversedBy: "tracks")]
    #[ORM\JoinColumn(name: "track_type_id", referencedColumnName: "id", nullable: false)]
    #[Groups(['posts:feed', 'user:swiper'])]
    private TrackType $type;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    public function getType(): TrackType
    {
        return $this->type;
    }

    public function setType(TrackType $type): static
    {
        $this->type = $type;

        return $this;
    }
}
