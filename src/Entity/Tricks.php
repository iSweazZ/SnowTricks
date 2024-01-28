<?php

namespace App\Entity;

use App\Repository\TricksRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TricksRepository::class)]
class Tricks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'tricks')]
    #[ORM\JoinColumn(nullable: false)]
    private User $publisher;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->comments = new ArrayCollection();
        $this->attachements = new ArrayCollection();
    }

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(type: 'string', nullable: false, enumType: TrickCategory::class)]
    private TrickCategory $category;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: Comments::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\Column(length: 255)]
    private ?string $bg_img = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: Attachements::class, cascade: ['PERSIST'])]
    private Collection $attachements;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPublisher(): User
    {
        return $this->publisher;
    }

    public function setPublisher(User $publisher): static
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getCategory(): TrickCategory
    {
        return $this->category;
    }

    public function setCategory(TrickCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }

    public function getBgImg(): ?string
    {
        return $this->bg_img;
    }

    public function setBgImg(string $bg_img): static
    {
        $this->bg_img = $bg_img;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection<int, Attachements>
     */
    public function getAttachements(): Collection
    {
        return $this->attachements;
    }

    public function addAttachement(Attachements $attachement): static
    {
        if (!$this->attachements->contains($attachement)) {
            $this->attachements->add($attachement);
            $attachement->setTrick($this);
        }

        return $this;
    }

    public function removeAttachement(Attachements $attachement): static
    {
        if ($this->attachements->removeElement($attachement)) {
            // set the owning side to null (unless already changed)
            if ($attachement->getTrick() === $this) {
                $attachement->setTrick(null);
            }
        }

        return $this;
    }
}
