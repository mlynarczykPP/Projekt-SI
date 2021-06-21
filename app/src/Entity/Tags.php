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
     * Getter for Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Name.
     *
     * @return string|null Name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for Name.
     *
     * @param string $name Name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Getter for notes.
     *
     * @return Collection|Note[] Notes collection
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    /**
     * Add note to collection.
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
     * Remove note from collection.
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
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

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }
}
