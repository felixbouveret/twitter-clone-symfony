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
    private $user;

    /**
     * @ORM\Column(type="string", length=245)
     */
    private $content;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="retweet")
     */
    private $retweeters;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="likes")
     */
    private $likes;

    /**
     * @ORM\ManyToOne(targetEntity=Tweets::class, inversedBy="response")
     * @ORM\JoinColumn(nullable=true)
     */
    private $mainTweet;

    /**
     * @ORM\OneToMany(targetEntity=Tweets::class, mappedBy="mainTweet")
     * @ORM\JoinColumn(nullable=true)
     */
    private $response;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActivated = true;

    public function __construct()
    {
        $this->retweeters = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->response = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getMainTweet(): ?self
    {
        return $this->mainTweet;
    }

    public function setMainTweet(?self $mainTweet): self
    {
        $this->mainTweet = $mainTweet;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getResponse(): Collection
    {
        return $this->response;
    }

    public function addResponse(self $response): self
    {
        if (!$this->response->contains($response)) {
            $this->response[] = $response;
            $response->setResponse($this);
        }

        return $this;
    }

    public function removeResponse(self $response): self
    {
        if ($this->response->removeElement($response)) {
            // set the owning side to null (unless already changed)
            if ($response->getResponse() === $this) {
                $response->setResponse(null);
            }
        }

        return $this;
    }

    public function getIsActivated(): ?bool
    {
        return $this->isActivated;
    }

    public function setIsActivated(bool $isActivated): self
    {
        $this->isActivated = $isActivated;

        return $this;
    }
}
