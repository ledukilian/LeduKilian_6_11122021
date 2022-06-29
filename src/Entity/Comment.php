<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use App\Traits\TimestampableTrait;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
{
    use TimestampableTrait;

    /**
     * @Groups("comment")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @Groups("comment")
     * @ORM\Column(type="string", length=2500)
     */
    private ?string $content;

    /**
     * @Groups("comment")
     * @ORM\Column(type="boolean")
     */
    private ?bool $status;

    /**
     * @Groups("comment")
     * @ORM\ManyToOne(targetEntity=User::class, fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(nullable=false)
     * @Ignore()
     */
    private ?User $user;

    /**
     * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="comments", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(nullable=false)
     * @Ignore()
     */
    private ?Trick $trick;

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
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getStatus(): ?bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function setStatus(bool $status): self
    {
        $this->status = $status;

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
     * @return Trick|null
     */
    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    /**
     * @param Trick|null $trick
     * @return $this
     */
    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }


}
