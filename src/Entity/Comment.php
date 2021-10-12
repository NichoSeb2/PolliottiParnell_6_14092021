<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentRepository;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment {
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
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status = 0;

    public function getId(): ?int {
        return $this->id;
    }

    public function getContent(): ?string {
        return $this->content;
    }

    public function setContent(string $content): self {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?User {
        return $this->author;
    }

    public function setAuthor(?User $author): self {
        $this->author = $author;

        return $this;
    }

    public function getTrick(): ?Trick {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self {
        $this->trick = $trick;

        return $this;
    }

    public function getStatus(): ?bool {
        return $this->status;
    }

    public function setStatus(bool $status): self {
        $this->status = $status;

        return $this;
    }
}
