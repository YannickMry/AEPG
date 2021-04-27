<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MemberRepository;
use DateTimeImmutable;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity(repositoryClass=MemberRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Member
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $currentJob;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebookLink;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkedinLink;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDisplayed;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Promotion::class, inversedBy="members")
     * @ORM\JoinColumn(nullable=false)
     */
    private $promotion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $renewalToken;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $renewalSentAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $renewalAnswer;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $renewalAnswerAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate(PreUpdateEventArgs $event)
    {
        $fieldsToLook = ['lastname', 'firstname', 'email', 'currentJob', 'facebookLink', 'linkedinLink', 'picture'];

        foreach ($event->getEntityChangeSet() as $key => $value) {
            if (in_array($key, $fieldsToLook)) {
                $this->updatedAt = new DateTimeImmutable();
                return;
            }
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Create or upadate slug automatically when creating or updating an Article
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function createOrUpdateSlug()
    {
        $slufify = new Slugify();

        $this->slug = $slufify->slugify($this->getFullName());
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCurrentJob(): ?string
    {
        return $this->currentJob;
    }

    public function setCurrentJob(?string $currentJob): self
    {
        $this->currentJob = $currentJob;

        return $this;
    }

    public function getFacebookLink(): ?string
    {
        return $this->facebookLink;
    }

    public function setFacebookLink(?string $facebookLink): self
    {
        $this->facebookLink = $facebookLink;

        return $this;
    }

    public function getLinkedinLink(): ?string
    {
        return $this->linkedinLink;
    }

    public function setLinkedinLink(?string $linkedinLink): self
    {
        $this->linkedinLink = $linkedinLink;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getisDisplayed(): ?bool
    {
        return $this->isDisplayed;
    }

    public function setisDisplayed(bool $isDisplayed): self
    {
        $this->isDisplayed = $isDisplayed;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getRenewalToken(): ?string
    {
        return $this->renewalToken;
    }

    public function setRenewalToken(?string $renewalToken): self
    {
        $this->renewalToken = $renewalToken;

        return $this;
    }

    public function getRenewalSentAt(): ?\DateTimeInterface
    {
        return $this->renewalSentAt;
    }

    public function setRenewalSentAt(?\DateTimeInterface $renewalSentAt): self
    {
        $this->renewalSentAt = $renewalSentAt;

        return $this;
    }

    public function getRenewalAnswer(): ?string
    {
        return $this->renewalAnswer;
    }

    public function setRenewalAnswer(?string $renewalAnswer): self
    {
        $this->renewalAnswer = $renewalAnswer;

        return $this;
    }

    public function getRenewalAnswerAt(): ?\DateTimeInterface
    {
        return $this->renewalAnswerAt;
    }

    public function setRenewalAnswerAt(?\DateTimeInterface $renewalAnswerAt): self
    {
        $this->renewalAnswerAt = $renewalAnswerAt;

        return $this;
    }

    public function getFullName(): string
    {
        return $this->lastname . " " . $this->firstname;
    }
}
