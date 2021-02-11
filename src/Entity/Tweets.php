<?php

namespace App\Entity;

use App\Repository\TweetsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TweetsRepository::class)
 */
class Tweets
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tweets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    /**
     * @ORM\Column(type="string", length=245)
     */
    private $content;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity=Tweets::class, cascade={"persist", "remove"})
     */
    private $id_parent_tweet;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="retweet")
     */
    private $retweeters;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="likes")
     */
    private $likes;

    public function __construct()
    {
        $this->retweeters = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdParentTweet(): ?self
    {
        return $this->id_parent_tweet;
    }

    public function setIdParentTweet(?self $id_parent_tweet): self
    {
        $this->id_parent_tweet = $id_parent_tweet;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getRetweeters(): Collection
    {
        return $this->retweeters;
    }

    public function addRetweeter(User $retweeter): self
    {
        if (!$this->retweeters->contains($retweeter)) {
            $this->retweeters[] = $retweeter;
            $retweeter->addRetweet($this);
        }

        return $this;
    }

    public function removeRetweeter(User $retweeter): self
    {
        if ($this->retweeters->removeElement($retweeter)) {
            $retweeter->removeRetweet($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(User $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
        }

        return $this;
    }

    public function removeLike(User $like): self
    {
        $this->likes->removeElement($like);

        return $this;
    }
}
