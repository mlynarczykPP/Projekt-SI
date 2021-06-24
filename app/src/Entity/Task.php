<?php

/**
 * Task Entity.
 */

namespace App\Entity;

use App\Repository\TaskRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Task.
 *
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 * @ORM\Table(name="tasks")
 */
class Task
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
     * Categories.
     *
     * @ORM\ManyToOne(
     *     targetEntity=Categories::class,
     *     inversedBy="tasks"
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private $categories;

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
     * Author.
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
     * Priority.
     *
     * @ORM\Column(
     *     type="integer",
     *     nullable=true,
     *     options={"unsigned":true, "default":0}
     *)
     */
    private $priority;

    /**
     * Tags.
     *
     * @var array
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Tags",
     *     inversedBy="tasks",
     * )
     * @ORM\JoinTable(name="task_tags")
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

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
     * Getter for the categories.
     *
     * @return categories|null Categories
     */
    public function getCategories(): ?categories
    {
        return $this->categories;
    }

    /**
     * Setter for the categories.
     *
     * @param categories|null $categories Categories
     */
    public function setCategories(?categories $categories): void
    {
        $this->categories = $categories;
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
     * Getter for the priority.
     *
     * @return int|null Priority
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * Setter for the priority.
     *
     * @param int|null $priority Priority
     */
    public function setPriority(?int $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * Getter for the Tag.
     *
     * @return Collection|Tags[]
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
}
