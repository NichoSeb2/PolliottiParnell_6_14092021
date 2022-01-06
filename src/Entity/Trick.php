<?php

namespace App\Entity;

use DateTime;
use App\Service\SlugConvertor;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TrickRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TrickRepository::class)
 * @UniqueEntity(fields={"name"}, message="Il existe déjà un trick avec ce nom")
 * @UniqueEntity(fields={"slug"}, message="Il existe déjà un trick avec cette slug")
 */
class Trick {
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
     * @ORM\OneToMany(targetEntity=Media::class, mappedBy="trick", orphanRemoval=true)
     */
    private $medias;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="trick", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="contributions")
     */
    private $contributors;

    /**
     * @ORM\OneToOne(targetEntity=Media::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $coverImage;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     */
    private $slug;

    public function __construct(private SlugConvertor $slugify, private EntityManager $entityManager) {
        $this->medias = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->contributors = new ArrayCollection();

        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
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
    public function getMedias(): Collection {
        return $this->medias;
    }

    /**
     * @param Collection|Media[]
     */
    public function setMedias($medias): self {
        $this->medias = $medias;

        return $this;
    }

    public function addMedia(Media $media): self {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
            $media->setTrick($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self {
        if ($this->medias->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getTrick() === $this) {
                $media->setTrick(null);
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

    public function getAuthor(): ?User {
        return $this->author;
    }

    public function setAuthor(?User $author): self {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * @param Collection|Comment[]
     */
    public function setComments($comments): self {
        $this->comments = $comments;

        return $this;
    }

    public function addComment(Comment $comment): self {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category {
        return $this->category;
    }

    public function setCategory(?Category $category): self {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getContributors(): Collection {
        return $this->contributors;
    }

    public function addContributor(User $contributor): self {
        if (!$this->contributors->contains($contributor)) {
            $this->contributors[] = $contributor;
        }

        return $this;
    }

    public function removeContributor(User $contributor): self {
        $this->contributors->removeElement($contributor);

        return $this;
    }

    public function getCoverImage(): ?Media {
        return $this->coverImage;
    }

    public function setCoverImage(?Media $coverImage): self {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getSlug(): ?string {
        return $this->slug;
    }

    public function updateSlug(): self {
        $trickRepository = $this->entityManager->getRepository(self::class);

        $slug = $this->slugify->slugify($this->getName());

        $slugDuplicator = 1;
        while (!is_null($trickRepository->findOneBy(['slug' => $slug]))) {
            $slug = $this->slugify->slugify($this->getName(). " ". $slugDuplicator);

            $slugDuplicator++;
        }

        $this->setSlug($slug);

        return $this;
    }

    public function setSlug(string $slug): self {
        $this->slug = $slug;

        return $this;
    }
}
