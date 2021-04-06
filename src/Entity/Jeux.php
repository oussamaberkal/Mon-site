<?php

namespace App\Entity;

use App\Repository\JeuxRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JeuxRepository::class)
 */
class Jeux
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
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateSortie;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lienYoutube;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lienPreco;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $editeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dev;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;



    public function getContentEllipsis() 
    {
        $text = substr($this->description, 0,100);
        $dots = strlen($this->description) > 100 ? ' ...' : '';
        return $text . $dots;
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

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->dateSortie;
    }

    public function setDateSortie(?\DateTimeInterface $dateSortie): self
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLienYoutube(): ?string
    {
        return $this->lienYoutube;
    }

    public function setLienYoutube(string $lienYoutube): self
    {
        $this->lienYoutube = $lienYoutube;

        return $this;
    }

    public function getLienPreco(): ?string
    {
        return $this->lienPreco;
    }

    public function setLienPreco(string $lienPreco): self
    {
        $this->lienPreco = $lienPreco;

        return $this;
    }

    public function getEditeur(): ?string
    {
        return $this->editeur;
    }

    public function setEditeur(string $editeur): self
    {
        $this->editeur = $editeur;

        return $this;
    }

    public function getDev(): ?string
    {
        return $this->dev;
    }

    public function setDev(string $dev): self
    {
        $this->dev = $dev;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }


}
