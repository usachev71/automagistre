<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Person extends Operand
{
    /**
     * @var string
     *
     * @ORM\Column(length=32, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @Assert\Email
     *
     * @ORM\Column(nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(length=24, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(length=24, nullable=true)
     */
    private $officePhone;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $spriteId;

    public function __toString(): string
    {
        return sprintf('%s (%s)', $this->getFullName(), $this->getTelephone() ?: $this->getOfficePhone());
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getOfficePhone(): ?string
    {
        return $this->officePhone;
    }

    public function setOfficePhone(string $officePhone): void
    {
        $this->officePhone = $officePhone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getFullName(): string
    {
        return sprintf('%s %s', $this->lastname, $this->firstname);
    }
}
