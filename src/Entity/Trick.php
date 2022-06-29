<?php

namespace App\Entity;


use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Traits\TimestampableTrait;

/**
 * @ORM\Entity(repositoryClass=TrickRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Trick
{
    use TimestampableTrait;

    /**
     * @Groups("trick")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @Groups("trick")
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @Groups("trick")
     * @ORM\Column(type="string", length=5000)
     */
    private ?string $description;

    /**
     * @Groups("trick")
     * @ORM\Column(type="string", length=255)
     */
    private ?string $slug;

    /**
     * @ORM\OneToMany(targetEntity=Contributor::class, mappedBy="trick", orphanRemoval=true, fetch="EAGER", cascade={"persist", "remove"})
     */
    private $contributors;

    /**
     * @Groups("user")
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tricks", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $user;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Category $category;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="trick", orphanRemoval=true)
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity=Media::class, fetch="EAGER", cascade={"persist", "remove"})
     */
    private $medias;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class, fetch="EAGER", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Media $coverImg;


    public function __construct()
    {
        $this->contributors = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->media = new ArrayCollection();
        $this->medias = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return $this
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getContributors(): Collection
    {
        return $this->contributors;
    }

    /**
     * @param Contributor $contributor
     * @return $this
     */
    public function addContributor(Contributor $contributor): self
    {
        if (!$this->contributors->contains($contributor)) {
            $this->contributors[] = $contributor;
            $contributor->setTrick($this);
        }

        return $this;
    }

    /**
     * @param Contributor $contributor
     * @return $this
     */
    public function removeContributor(Contributor $contributor): self
    {
        if ($this->contributors->removeElement($contributor)) {
            // set the owning side to null (unless already changed)
            if ($contributor->getTrick() === $this) {
                $contributor->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setUserId(int $id): self
    {
        $this->user = $id;

        return $this;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     * @return $this
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setCategoryId(int $id): self
    {
        $this->category = $id;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTrick($this);
        }

        return $this;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    /**
     * @param Media $media
     * @return $this
     */
    public function addMedia(Media $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
        }

        return $this;
    }

    /**
     * @param Media $media
     * @return $this
     */
    public function removeMedia(Media $media): self
    {
        $this->medias->removeElement($media);

        return $this;
    }

    /**
     * @return Media|null
     */
    public function getCoverImg(): ?Media
    {
        return $this->coverImg;
    }

    /**
     * @param Media|null $coverImg
     * @return $this
     */
    public function setCoverImg(?Media $coverImg): self
    {
        $this->coverImg = $coverImg;

        return $this;
    }






}
