<?php

namespace App\Traits;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Contributor;
use App\Entity\Media;
use App\Entity\Trick;
use App\Entity\User;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

trait TimestampableTrait
{
    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private ?DateTimeInterface $updatedAt;

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface|null $timestamp
     * @return User|Category|Comment|Contributor|Media|Trick|TimestampableTrait
     */
    public function setCreatedAt(?DateTimeInterface $timestamp): self
    {
        $this->createdAt = $timestamp;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface|null $timestamp
     * @return User|Category|Comment|Contributor|Media|Trick|TimestampableTrait
     */
    public function setUpdatedAt(?DateTimeInterface $timestamp): self
    {
        $this->updatedAt = $timestamp;
        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtAutomatically(): void
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime());
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtAutomatically()
    {
        $this->setUpdatedAt(new \DateTime());
    }
}
