<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use App\Repository\UserProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
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

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];



    /**
     * @ORM\Column(type="float")
     */
    private $couronnes;

    public function __construct()
    {
        $this->userproduit = new ArrayCollection();
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserProduit", mappedBy="user", cascade={"persist"})
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


    /**
     * @param UserProduit $userproduit
     */
    public function addproduit($userproduit,$quantity)
    {
        $userproduit->setQuantity($quantity);
        $this->userproduit[] = $userproduit;
    }

    /**
     * @param UserProduit $userproduit
     */
    public function removeProduit($userproduit)
    {
        $this->userproduit->removeElement($userproduit);
    }

    // ...
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }


    public function getCouronnes(): ?float
    {
        return $this->couronnes;
    }

    public function setCouronnes(float $couronnes) : self
    {
        $this->couronnes = $couronnes;
        echo $this->couronnes;
        return $this;
    }

    /*public function achat(float $prix /*,int $quantity){

        return $this->getCouronnes();
    }*/


}
