<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TricksRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=TricksRepository::class)
 */
class Tricks {
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Media::class, mappedBy="tricks")
     */
    private $media;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct() {
        $this->media = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Media[]
     */
    public function getMedia(): Collection {
        return $this->media;
    }

    public function addMedia(Media $media): self {
        if (!$this->media->contains($media)) {
            $this->media[] = $media;
            $media->setTricks($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self {
        if ($this->media->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getTricks() === $this) {
                $media->setTricks(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): self {
        $this->description = $description;

        return $this;
    }
}
