<?php

namespace App\Entity;

use App\Repository\TrackRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TrackRepository::class)]
class Track
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['posts:feed'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tracks')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\Column]
    #[Groups(['posts:feed'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    #[Groups(['posts:feed'])]
    private ?string $trackUrl = null;

    #[ORM\Column(nullable: true)]
    private ?int $featuredOrder = null;

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

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTrackUrl(): ?string
    {
        return $this->trackUrl;
    }

    public function setTrackUrl(string $trackUrl): static
    {
        $this->trackUrl = $trackUrl;

        return $this;
    }

    public function getFeaturedOrder(): ?int
    {
        return $this->featuredOrder;
    }

    public function setFeaturedOrder(?int $featuredOrder): static
    {
        $this->featuredOrder = $featuredOrder;

        return $this;
    }
}
