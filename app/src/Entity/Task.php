<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Task
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
     * Comment
     *
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * Categories
     *
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="tasks")
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
     * Author
     *
     * @ORM\ManyToOne(
     *     targetEntity=User::class,
     *     fetch="EXTRA_LAZY"
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * Priority
     *
     * @ORM\Column(
     *     type="integer",
     *     nullable=true,
     *     options={"unsigned":true, "default":0}
     *)
     *
     * )
     */
    private $priority;

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

    public function getCategories(): ?categories
    {
        return $this->categories;
    }

    public function setCategories(?categories $categories): void
    {
        $this->categories = $categories;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): void
    {
        $this->priority = $priority;
    }
}
