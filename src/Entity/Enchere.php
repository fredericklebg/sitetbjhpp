<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnchereRepository")
 */
class Enchere
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }



    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $dateFin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Produit", inversedBy="encheres", cascade={"persist"})
     * @Assert\NotNull()
     */
    private $produit;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HistoriqueEncheres", mappedBy="enchere")
     */
    private $historiqueEncheres;

    public function __construct()
    {
        $this->historiqueEncheres = new ArrayCollection();
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * @return Collection|HistoriqueEncheres[]
     */
    public function getHistoriqueEncheres(): Collection
    {
        return $this->historiqueEncheres;
    }

    public function addHistoriqueEnchere(HistoriqueEncheres $historiqueEnchere): self
    {
        if (!$this->historiqueEncheres->contains($historiqueEnchere)) {
            $this->historiqueEncheres[] = $historiqueEnchere;
            $historiqueEnchere->setEnchere($this);
        }

        return $this;
    }

    public function removeHistoriqueEnchere(HistoriqueEncheres $historiqueEnchere): self
    {
        if ($this->historiqueEncheres->contains($historiqueEnchere)) {
            $this->historiqueEncheres->removeElement($historiqueEnchere);
            // set the owning side to null (unless already changed)
            if ($historiqueEnchere->getEnchere() === $this) {
                $historiqueEnchere->setEnchere(null);
            }
        }

        return $this;
    }
}



