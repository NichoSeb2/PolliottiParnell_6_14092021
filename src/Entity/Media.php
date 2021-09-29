<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MediaRepository;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 */
class Media {
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
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alt;

    /**
     * @ORM\ManyToOne(targetEntity=Tricks::class, inversedBy="media")
     */
    private $tricks;

    public function getId(): ?int {
        return $this->id;
    }

    public function getUrl(): ?string {
        return $this->url;
    }

    public function setUrl(string $url): self {
        $this->url = $url;

        return $this;
    }

    public function getAlt(): ?string {
        return $this->alt;
    }

    public function setAlt(?string $alt): self {
        $this->alt = $alt;

        return $this;
    }

    public function getTricks(): ?Tricks {
        return $this->tricks;
    }

    public function setTricks(?Tricks $tricks): self {
        $this->tricks = $tricks;

        return $this;
    }
}
