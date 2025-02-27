<?php

namespace App\Entity;

use App\Repository\SwipeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Entity(repositoryClass: SwipeRepository::class)]
#[ORM\UniqueConstraint(name: "unique_swipe", columns: ["user_id", "swiped_user_id"])]
class Swipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Ignore]
    private int $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "swipes")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private $user;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "receivedSwipes")]
    #[ORM\JoinColumn(name: "swiped_user_id", referencedColumnName: "id")]
    private $swipedUser;

    #[ORM\Column(type: "boolean")]
    private bool $liked;

    #[ORM\Column(type: "datetime_immutable", options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: "datetime_immutable", nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getSwipedUser(): ?User
    {
        return $this->swipedUser;
    }

    public function setSwipedUser(?User $swipedUser): self
    {
        $this->swipedUser = $swipedUser;
        return $this;
    }

    public function isLiked(): bool
    {
        return $this->liked;
    }

    public function setLiked(bool $liked): self
    {
        $this->liked = $liked;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
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

    public function getId(): ?int
    {
        return $this->id;
    }
}
