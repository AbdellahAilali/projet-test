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
     * @var string $email
     *
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email
     * @Assert\NotBlank
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    protected $question;

    /**
     * @var bool $isCheck
     * @ORM\Column(type="boolean")
     */
    protected $isCheck = true;

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