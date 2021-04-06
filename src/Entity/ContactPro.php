<?php

namespace App\Entity;

use App\Repository\ContactProRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=ContactProRepository::class)
 */
class ContactPro
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci! d'indiquer votre Pseudo")
     */
    private $pseudo;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci! d'indiquer votre Email")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci! d'indiquer votre Sujet")
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Merci! d'indiquer un Message")
     * @Assert\Length(
     * min=50, 
     * minMessage = "Merci! d'écrire au moin {{ limit }} caractères")
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sentAt;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getSentAt(): ?DateTimeInterface
    {
        return $this->sentAt;
    }

    public function setSentAt(DateTimeInterface $sentAt): self
    {
        $this->sentAt = $sentAt;

        return $this;
    }
}
