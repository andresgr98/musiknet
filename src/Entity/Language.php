<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["user:swiper", "language:get"])]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(["user:swiper", "language:get"])]
    private string $name;

    #[ORM\Column(type: "string", length: 10)]
    #[Groups(["user:swiper", "language:get"])]
    private string $isoCode;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: "languages")]
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

    public function getIsoCode(): string
    {
        return $this->isoCode;
    }

    public function setIsoCode(string $isoCode): self
    {
        $this->isoCode = $isoCode;
        return $this;
    }
}
