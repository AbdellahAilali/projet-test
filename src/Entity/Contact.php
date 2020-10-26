<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 *
 * @ORM\Table(name="Contact")
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 * @package App\Entity
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    protected $name;

    /**
     * @var string $firstname
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    protected $firstname;

    /**
     * @var string $email
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.")
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    protected $question;

    /**
     * @var bool $isCheck
     * @ORM\Column(type="boolean")
     */
    protected $isCheck = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed $question
     */
    public function setQuestion($question): void
    {
        $this->question = $question;
    }

    /**
     * @return bool
     */
    public function isCheck(): bool
    {
        return $this->isCheck;
    }

    /**
     * @param bool $isCheck
     */
    public function setIsCheck(bool $isCheck): void
    {
        $this->isCheck = $isCheck;
    }

    /**
     * @param bool $isCheck
     */
    public function updateCheck(bool $isCheck)
    {
        $this->isCheck = $isCheck;
    }
}