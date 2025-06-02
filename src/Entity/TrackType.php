<?php

namespace App\Entity;

use App\Repository\TrackTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: TrackTypeRepository::class)]
class TrackType
{
    public const TYPE_MAIN = 1;
    public const TYPE_PROFILE = 2;
    public const TYPE_POST = 3;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['posts:feed'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['posts:feed'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: "type", targetEntity: Track::class)]
    #[Ignore]
    private Collection $tracks;

    public function __construct()
    {
        $this->tracks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
