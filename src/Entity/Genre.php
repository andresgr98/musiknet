<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["user:swiper", "genre:get"])]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(["user:swiper", "genre:get"])]
    private string $name;

    #[ORM\Column(type: "text", nullable: true)]
    #[Groups(["user:swiper", "genre:get"])]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: "genres")]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }
}
