<?php

/**
 * Tags entity.
 */

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Tags.
 *
 * @ORM\Entity(repositoryClass="App\Repository\TagsRepository")
 * @ORM\Table(name="tags")
 */
class Tags
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
     * Name.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=64,
     * )
     */
    private $name;

    /**
     * Notes.
     *
     * @var ArrayCollection|Note[] Note
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Note",
     *     mappedBy="tags"
     * )
     */
    private $notes;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->tasks = new ArrayCollection();
    }

    /**
     * Code.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=64
     * )
     *
     * @Gedmo\Slug(fields={"name"})
     */
    private $code;

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
     * Tasks.
     *
     * @ORM\ManyToMany(
     *     targetEntity=Task::class,
     *     mappedBy="tags"
     * )
     */
    private $tasks;

    /**
     * Author.
     *
     * @var User User entity
     *
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

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
     * Getter for the Name.
     *
     * @return string|null Name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for the Name.
     *
     * @param string $name Name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Getter for the notes.
     *
     * @return Collection Notes collection
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    /**
     * Add note to the collection.
     *
     * @param Note $notes Note entity
     */
    public function addTask(Note $notes): void
    {
        if (!$this->notes->contains($notes)) {
            $this->notes[] = $notes;
            $notes->addTag($this);
        }
    }

    /**
     * Remove note from the collection.
     *
     * @param Note $notes Note entity
     */
    public function removeTask(Note $notes): void
    {
        if ($this->notes->contains($notes)) {
            $this->notes->removeElement($notes);
            $notes->removeTag($this);
        }
    }

    /**
     * Getter for the code.
     *
     * @return string|null Code
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Setter for the code.
     *
     * @param string $code Code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
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
     * Getter for the task.
     *
     * @return Collection Task
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
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
}
