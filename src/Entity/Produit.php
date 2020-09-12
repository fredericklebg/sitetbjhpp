<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function __toString()
    {
        return $this->name;
    }


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\File(mimeTypes={"image/jpeg","image/gif","image/png"})
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Marche", mappedBy="produit")
     */
    private $marches;



    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    public function __construct()
    {
        $this->marches = new ArrayCollection();
        $this->userproduit = new ArrayCollection();

    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserProduit", mappedBy="produit", cascade={"persist"})
     */
    private $userproduit;

    /**
     * @return ArrayCollection
     */
    public function getUserproduit(): ArrayCollection
    {
        return $this->userproduit;
    }

    /**
     * @param ArrayCollection $userproduit
     */
    public function setUserproduit(ArrayCollection $userproduit): void
    {
        $this->userproduit = $userproduit;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }



    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    /**
     * @return Collection|Marche[]
     */
    public function getMarches(): Collection
    {
        return $this->marches;
    }

    public function addMarch(Marche $march): self
    {
        if (!$this->marches->contains($march)) {
            $this->marches[] = $march;
            $march->addProduit($this);
        }

        return $this;
    }

    public function removeMarch(Marche $march): self
    {
        if ($this->marches->contains($march)) {
            $this->marches->removeElement($march);
            $march->removeProduit($this);
        }

        return $this;
    }


    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
