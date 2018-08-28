<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     */
    private $votes;

    /**
     * @ORM\Column(type="integer")
     */
    private $timestamp;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VoteRecord", mappedBy="Post")
     */
    private $voteRecords;

    public function __construct()
    {
        $this->voteRecords = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getVotes(): ?int
    {
        return $this->votes;
    }

    public function setVotes(int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }

    public function getTimestamp(): ?int
    {
        return $this->timestamp;
    }

    public function setTimestamp(int $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @return Collection|VoteRecord[]
     */
    public function getVoteRecords(): Collection
    {
        return $this->voteRecords;
    }

    public function addVoteRecord(VoteRecord $voteRecord): self
    {
        if (!$this->voteRecords->contains($voteRecord)) {
            $this->voteRecords[] = $voteRecord;
            $voteRecord->setPost($this);
        }

        return $this;
    }

    public function removeVoteRecord(VoteRecord $voteRecord): self
    {
        if ($this->voteRecords->contains($voteRecord)) {
            $this->voteRecords->removeElement($voteRecord);
            // set the owning side to null (unless already changed)
            if ($voteRecord->getPost() === $this) {
                $voteRecord->setPost(null);
            }
        }

        return $this;
    }
}
