<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AchatRepository")
 */
class Achat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_achat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PackJetons", inversedBy="achats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nbJetons;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="achats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->date_achat;
    }

    public function setDateAchat(\DateTimeInterface $date_achat): self
    {
        $this->date_achat = $date_achat;

        return $this;
    }

    public function getNbJetons(): ?PackJetons
    {
        return $this->nbJetons;
    }

    public function setNbJetons(?PackJetons $nbJetons): self
    {
        $this->nbJetons = $nbJetons;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
