<?php

namespace App\Entity;

use DateTime;
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
     * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="medias")
     */
    private $trick;

    public function __construct() {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

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

    public function getTrick(): ?Trick {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self {
        $this->trick = $trick;

        return $this;
    }

    public function getType() {
        $parse = parse_url($this->url);

        if (isset($parse['host'])) {
            if (preg_match("#youtu(?:be\.com|\.be)#", $parse['host'])) {
                // youtube link
                return "youtube";
            } else if (preg_match("#vimeo(?:\.com)#", $parse['host'])) {
                // vimeo link
                return "vimeo";
            }
        } else {
            // local image
            return "image";
        }
    }
}
