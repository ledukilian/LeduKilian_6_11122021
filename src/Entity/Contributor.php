<?php

namespace App\Entity;

use App\Repository\ContributorRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\TimestampableTrait;

/**
 * @ORM\Entity(repositoryClass=ContributorRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Contributor
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="contributors")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Trick $trick;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $user;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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

}
