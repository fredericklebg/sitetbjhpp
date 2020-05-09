<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Cet email est déjà utilisé"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=8, minMessage="votre Mot de passe doit faire 8 caractères minimums")
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passe doivent être identiques")
     */
    public $confirm_password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HistoriqueEncheres", mappedBy="user")
     */
    private $historiqueEncheres;

    public function __construct()
    {
        $this->historiqueEncheres = new ArrayCollection();
        $this->achats = new ArrayCollection();
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getSalt()
    {
    // TODO: Implement getSalt() method.
    }

    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Achat", mappedBy="user", orphanRemoval=true)
     */
    private $achats;

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @return Collection|HistoriqueEncheres[]
     */
    public function getHistoriqueEncheres(): Collection
    {
        return $this->historiqueEncheres;
    }

    public function addHistoriqueEncheres(HistoriqueEncheres $historiqueEncheres): self
    {
        if (!$this->historiqueEncheres->contains($historiqueEncheres)) {
            $this->historiqueEncheres[] = $historiqueEncheres;
            $historiqueEncheres->setUser($this);
        }

        return $this;
    }

    public function removeHistoriqueEncheres(HistoriqueEncheres $historiqueEncheres): self
    {
        if ($this->historiqueEncheres->contains($historiqueEncheres)) {
            $this->historiqueEncheres->removeElement($historiqueEncheres);
            // set the owning side to null (unless already changed)
            if ($historiqueEncheres->getUser() === $this) {
                $historiqueEncheres->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Achat[]
     */
    public function getAchats(): Collection
    {
        return $this->achats;
    }

    public function addAchat(Achat $achat): self
    {
        if (!$this->achats->contains($achat)) {
            $this->achats[] = $achat;
            $achat->setUser($this);
        }

        return $this;
    }

    public function removeAchat(Achat $achat): self
    {
        if ($this->achats->contains($achat)) {
            $this->achats->removeElement($achat);
            // set the owning side to null (unless already changed)
            if ($achat->getUser() === $this) {
                $achat->setUser(null);
            }
        }

        return $this;
    }
}
