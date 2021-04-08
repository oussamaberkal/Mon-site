<?php

namespace App\Entity;

use App\Repository\PlateformeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlateformeRepository::class)
 */
class Plateforme
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
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Jeux::class, mappedBy="plateforme")
     */
    private $jeux;

    public function __construct()
    {
        $this->jeux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Jeux[]
     */
    public function getJeux(): Collection
    {
        return $this->jeux;
    }

    public function addJeux(Jeux $jeux): self
    {
        if (!$this->jeux->contains($jeux)) {
            $this->jeux[] = $jeux;
            $jeux->addPlateforme($this);
        }

        return $this;
    }

    public function removeJeux(Jeux $jeux): self
    {
        if ($this->jeux->removeElement($jeux)) {
            $jeux->removePlateforme($this);
        }

        return $this;
    }
}
