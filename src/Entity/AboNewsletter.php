<?php

namespace App\Entity;

use App\Repository\AboNewsletterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=AboNewsletterRepository::class)
 * @UniqueEntity(fields={"email"}, message="Vous etes déja abonné a la newsletter avec cette adresse émail.")
 */
class AboNewsletter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

        
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
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
}
