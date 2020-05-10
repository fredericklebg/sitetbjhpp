<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MaraisRepository")
 */
class Marais
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Marche", mappedBy="marais", orphanRemoval=true)
     */
    private $marche;

    public function __construct()
    {
        $this->marche = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Marche[]
     */
    public function getMarche(): Collection
    {
        return $this->marche;
    }

    public function addMarche(Marche $marche): self
    {
        if (!$this->marche->contains($marche)) {
            $this->marche[] = $marche;
            $marche->setMarais($this);
        }

        return $this;
    }

    public function removeMarche(Marche $marche): self
    {
        if ($this->marche->contains($marche)) {
            $this->marche->removeElement($marche);
            // set the owning side to null (unless already changed)
            if ($marche->getMarais() === $this) {
                $marche->setMarais(null);
            }
        }

        return $this;
    }
}
