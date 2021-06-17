<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Note
 *
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 * @ORM\Table(name="notes")
 */
class Note
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Title.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     * )
     */
    private $title;

    /**
     * Comment
     *
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * Tags
     *
     * @ORM\ManyToOne(targetEntity=Tags::class, inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tags;

    /**
     * Created at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $createdAt;

    /**
     * Updated at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * Author
     *
     * @ORM\ManyToOne(
     *     targetEntity=User::class,
     *     fetch="EXTRA_LAZY"
     * )
     *
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, mappedBy="note", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * Getter for Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Title.
     *
     * @return string|null Title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Getter for Comment.
     *
     * @return string|null Comment
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * Setter for Title.
     *
     * @param string $title Title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Setter for Comment.
     *
     * @param string $comment Comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * Getter for tags
     *
     * @return Tags|null Tags
     */
    public function getTags(): ?Tags
    {
        return $this->tags;
    }

    /**
     * Setter for tags
     *
     * @param Tags|null $tags Tags
     */
    public function setTags(?Tags $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * Getter for created at
     *
     * @return DateTimeInterface|null Created At
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Setter for created at
     *
     * @param DateTimeInterface $createdAt Created At
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for updated at
     *
     * @return DateTimeInterface|null Updated At
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Setter for updated at
     *
     * @param DateTimeInterface $updatedAt Updated At
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Getter fo author
     *
     * @return User|null Author
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Setter for author
     *
     * @param User|null $author Author
     */
    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }

    /**
     * Getter for image
     *
     * @return Image|null Image
     */
    public function getImage(): ?Image
    {
        return $this->image;
    }

    /**
     * Setter for image
     *
     * @param Image|null $image Image
     */
    public function setImage(?Image $image): void
    {
        // unset the owning side of the relation if necessary
        if ($image === null && $this->image !== null) {
            $this->image->setNote(null);
        }

        // set the owning side of the relation if necessary
        if ($image !== null && $image->getNote() !== $this) {
            $image->setNote($this);
        }

        $this->image = $image;
    }
}
