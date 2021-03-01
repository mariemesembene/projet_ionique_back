<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AgencesRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AgencesRepository::class)
 *    @ApiResource(
 * itemOperations={
 *           "get_agence"={
 *              "normalization_context" ={"groups" ={"agence:read"}},   
 *              "method"="GET",
 *              "path"="/agence/{id}/user"  ,
 *              "defaults"={"id"=null}
 *             
 *              
 *          },
 *          "user_agence_compte"={
 *              "normalization_context" ={"groups" ={"useragence:read"}},   
 *              "method"="GET",
 *              "path"="/user/agence/{id}/compte/{id1}"  ,
 *              "defaults"={"id"=null}
 *             
 *              
 *          },
 *    "get_amdin_agence"={
 *              "normalization_context" ={"groups" ={"parts:read"}},   
 *              "method"="GET",
 *              "path"="/admin/agence/{id}/parts"  ,
 *              "defaults"={"id"=null}
 *             
 *              
 *          },
 *    "PUT__agence_USER"={
 *              "normalization_context" ={"groups" ={"bloqueruser:read"}},   
 *              "method"="PUT",
 *              "path"="/agence/{id}/user/{id1} "  ,
 *              "defaults"={"id"=null}
 *             
 *              
 *          },
 *  "delete__agence_USER"={
 *            
 *              "method"="DELETE",
 *              "path"="/admin/agences/{id}  "  ,
 *              
 *             
 *              
 *          },
 *       },
 * collectionOperations={
 *           "post-compte"={
 *              "method"="POST",
 *              "path"="/admin/compte",
 *             
 *              
 *          },
 *       }
 * )
 */
class Agences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"transactioncompte:read","comptes:write","useragence:read","agence:read","parts:read","bloqueruser:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $longitude;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="agences")
     * @Groups({"agence:read","bloqueruser:read"})
     */
    private $users;


    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    /**
     * @ORM\OneToOne(targetEntity=Comptes::class, mappedBy="agence", cascade={"persist", "remove"})
     */
    private $comptes;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAgences($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAgences() === $this) {
                $user->setAgences(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return  $this->users;
  
      }

   

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getComptes(): ?Comptes
    {
        return $this->comptes;
    }

    public function setComptes(?Comptes $comptes): self
    {
        // unset the owning side of the relation if necessary
        if ($comptes === null && $this->comptes !== null) {
            $this->comptes->setAgence(null);
        }

        // set the owning side of the relation if necessary
        if ($comptes !== null && $comptes->getAgence() !== $this) {
            $comptes->setAgence($this);
        }

        $this->comptes = $comptes;

        return $this;
    }
}
