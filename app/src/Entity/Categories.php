<?php

/**
 * Categories entity.
 */

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Categories.
 *
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 * @ORM\Table(name="categories")
 *
 * @UniqueEntity(fields={"name"})
 */
class Categories
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
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private $name;

    /**
     * Tasks.
     *
     * @var ArrayCollection|Task[] Tasks
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Task",
     *     mappedBy="categories",
     * )
     */
    private $tasks;

    /**
     * Notes.
     *
     * @var ArrayCollection|Note[] Notes
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Note",
     *     mappedBy="categories",
     * )
     */
    private $note;

    /**
     * Code.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=64,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="64",
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
     * @Gedmo\Timestampable(on="create")
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
     * Categories constructor.
     */
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
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
     * Getter for the Task.
     *
     * @return Collection Task
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    /**
     * Adding tasks.
     *
     * @param Task $task Task entity
     */
    public function addTask(Task $task): void
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setCategories($this);
        }
    }

    /**
     * Removing tasks.
     *
     * @param Task $task Task entity
     */
    public function removeTask(Task $task): void
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getCategories() === $this) {
                $task->setCategories(null);
            }
        }
    }

    /**
     * Getter for the notes.
     *
     * @return Collection Note
     */
    public function getNotes(): Collection
    {
        return $this->note;
    }

    /**
     * Adding notes.
     *
     * @param Note $note Note entity
     */
    public function addNotes(Note $note): void
    {
        if (!$this->note->contains($note)) {
            $this->note[] = $note;
            $note->setCategories($this);
        }
    }

    /**
     * Removing notes.
     *
     * @param Note $note Note entity
     */
    public function removeNote(Note $note): void
    {
        if ($this->note->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getCategories() === $this) {
                $note->setCategories(null);
            }
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
}
