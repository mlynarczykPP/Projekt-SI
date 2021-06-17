<?php
/**
 * Image
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Image
 *
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @ORM\Table(
 *     name="images",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="UQ_fileName_1",
 *              columns={"filename"},
 *          ),
 *     },
 * )
 *
 * @UniqueEntity(
 *     fields={"filename"},
 * )
 */
class Image
{
    /**
     * Id
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Note
     *
     * @var \App\Entity\Note
     *
     * @ORM\OneToOne(
     *     targetEntity="App\Entity\Note",
     *     inversedBy="image",
     * )
     *
     * @ORM\JoinColumn(nullable=true)
     *
     * @Assert\Type(type="App\Entity\Note")
     */
    private $note;

    /**
     * Filename
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=128,
     * )
     *
     * @Assert\Type(type="string")
     */
    private $filename;

    /**
     * Getter fo id
     *
     * @return int|null ID
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for note
     *
     * @return Note|null Note
     */
    public function getNote(): ?Note
    {
        return $this->note;
    }

    /**
     * Setter fo note
     *
     * @param \App\Entity\Note $note Note
     */
    public function setNote(?Note $note): void
    {
        $this->note = $note;
    }

    /**
     * Getter for filename
     *
     * @return string|null Filename
     */
    public function getFileName(): ?string
    {
        return $this->filename;
    }

    /**
     * Setter for filename
     *
     * @param string $filename Filename
     */
    public function setFileName(string $filename): void
    {
        $this->filename = $filename;
    }
}
