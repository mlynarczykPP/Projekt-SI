<?php
/**
 * UserData Entity.
 */

namespace App\Entity;

use App\Repository\UserDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserData
 *
 * @ORM\Entity(repositoryClass=UserDataRepository::class)
 * @ORM\Table(name="usersdata")
 */
class UserData
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(
     *     name="id",
     *     type="integer",
     *     nullable=false,
     *     options={"unsigned"=true},
     * )
     */
    private ?int $id;

    /**
     * First name
     *
     * @ORM\Column(type="string", length=64)
     *
     */
    private ?string $firstname;

    /**
     * Last name
     *
     * @ORM\Column(type="string", length=128)
     */
    private ?string $lastname;

    /**
     * Getter for id
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for first name
     *
     * @return string|null First name
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Setter for first name
     *
     * @param string $firstname First name
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * Getter for last name
     *
     * @return string|null Last name
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Setter for last name
     *
     * @param string $lastname Last name
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * Transform to string
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
    }
}
