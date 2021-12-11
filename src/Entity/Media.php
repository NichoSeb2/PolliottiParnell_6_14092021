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
    public const UPLOAD_DIR = "./uploads/";
    public const ACCEPT_MIME_TYPE = "image/*";

    public const MEDIA_TYPE_LOCAL_FILE = "file";
    public const MEDIA_TYPE_URL = "url";

    public const MEDIA_IMAGE_TYPE = "image";
    public const MEDIA_VIDEO_TYPE_YOUTUBE = "youtube";
    public const MEDIA_VIDEO_TYPE_VIMEO = "vimeo";

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
                return self::MEDIA_VIDEO_TYPE_YOUTUBE;
            } else if (preg_match("#vimeo(?:\.com)#", $parse['host'])) {
                // vimeo link
                return self::MEDIA_VIDEO_TYPE_VIMEO;
            }
        } else {
            // local image
            return self::MEDIA_IMAGE_TYPE;
        }
    }
}
