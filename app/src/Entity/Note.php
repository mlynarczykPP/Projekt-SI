<?php

/**
 * Note Entity.
 */

namespace App\Entity;

use App\Repository\NoteRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Note.
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
     * Comment.
     *
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * Tags.
     *
     * @var array
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Tags",
     *     inversedBy="notes",
     * )
     * @ORM\JoinTable(name="note_tags")
     */
    private $tags;

    /**
     * Note constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * Created at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="update")
     */
    private DateTimeInterface $createdAt;

    /**
     * Updated at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="update")
     */
    private DateTimeInterface $updatedAt;

    /**
     * Author.
     *
     * @ORM\ManyToOne(
     *     targetEntity=User::class,
     *     fetch="EXTRA_LAZY"
     * )
     *
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $author;

    /**
     * Categories.
     *
     * @ORM\ManyToOne(
     *     targetEntity=Categories::class,
     *     inversedBy="tasks"
     * )
     */
    private ?Categories $categories;

    /**
     * Filename.
     *
     * @ORM\Column(
     *     type="string",
     *     length=128,
     *     nullable=true
     * )
     */
    private ?string $filename;

    /**
     * Getter for the Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for the Title.
     *
     * @return string|null Title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Getter for the Comment.
     *
     * @return string|null Comment
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * Setter for the Title.
     *
     * @param string $title Title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Setter for the Comment.
     *
     * @param string $comment Comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * Getter for the tags.
     *
     * @return Collection Tags collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * Add tag to the collection.
     *
     * @param Tags $tags Tag entity
     */
    public function addTag(Tags $tags): void
    {
        if (!$this->tags->contains($tags)) {
            $this->tags[] = $tags;
        }
    }

    /**
     * Remove tag from the collection.
     *
     * @param Tags $tags Tag entity
     */
    public function removeTag(Tags $tags): void
    {
        if ($this->tags->contains($tags)) {
            $this->tags->removeElement($tags);
        }
    }

    /**
     * Getter for the created at.
     *
     * @return DateTimeInterface|null Created At
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Setter for the created at.
     *
     * @param DateTimeInterface $createdAt Created At
     */
    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for the updated at.
     *
     * @return DateTimeInterface|null Updated At
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Setter for the updated at.
     *
     * @param DateTimeInterface $updatedAt Updated At
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Getter for the author.
     *
     * @return User|null Author
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Setter for the author.
     *
     * @param User|null $author Author
     */
    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }

    /**
     * Getter for the categories.
     *
     * @return Categories|null Categories
     */
    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    /**
     * Setter for the categories.
     *
     * @param Categories|null $categories Categories
     */
    public function setCategories(?Categories $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * Getter for the filename.
     *
     * @return string|null Filename
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * Setter for the filename.
     *
     * @param string|null $filename Filename
     */
    public function setFilename(?string $filename): void
    {
        $this->filename = $filename;
    }
}
