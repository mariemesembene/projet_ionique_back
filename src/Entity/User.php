<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 *  collectionOperations={
 * 
 *         "post_user"={
 *              "method"="POST",
 *              "path"="/admin/users",
 *           
 *              
 *          },
 *          "get_user"={
 *              "normalization_context" ={"groups" ={"getuser:read"}},  
 *              "method"="GET",
 *              "path"="/admin/users",
 *             
 *              
 *          },
 *         
 *          
 *       },
 *      itemOperations={
 *          "get_user-id"={
 *              "normalization_context" ={"groups" ={"getuser:read"}},     
 *              "method"="GET", 
 *              "path"="/admin/user/{id}",
 *              
 * 
 * 
 *          },
 *     "delete_user"={
 *                 "method"="DELETE",
 *                 "path"="admin/user/{id}",
 *                 
 *         },
 *       
 *               
 *    }
 * )    
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"transaction:write"})
     *  @Groups({"getuser:read","agence:read","caissier:read","bloqueruser:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"transaction:write","getuser:read","agence:read","caissier:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"transaction:write"})
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity=Roles::class, inversedBy="users")
     */
    private $rolesEntity;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction:write","getuser:read","agence:read","caissier:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction:write","getuser:read","agence:read","caissier:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction:write"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"transaction:write","bloqueruser:read"})
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="user")
     * @Groups({"transaction:write"})
     */
    private $transactions;

    /**
     * @ORM\ManyToOne(targetEntity=Agences::class, inversedBy="users")
     * @Groups({"transaction:write"})
     */
    private $agences;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="userRetrait")
     * @Groups({"transaction:write"})
     */
    private $transactionRetrait;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->statut=false;
        $this->transactionRetrait = new ArrayCollection();
    }

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getRolesEntity(): ?Roles
    {
        return $this->rolesEntity;
    }

    public function setRolesEntity(?Roles $rolesEntity): self
    {
        $this->rolesEntity = $rolesEntity;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
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

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setUser($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getUser() === $this) {
                $transaction->setUser(null);
            }
        }

        return $this;
    }

    public function getAgences(): ?Agences
    {
        return $this->agences;
    }

    public function setAgences(?Agences $agences): self
    {
        $this->agences = $agences;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactionRetrait(): Collection
    {
        return $this->transactionRetrait;
    }

    public function addTransactionRetrait(Transaction $transactionRetrait): self
    {
        if (!$this->transactionRetrait->contains($transactionRetrait)) {
            $this->transactionRetrait[] = $transactionRetrait;
            $transactionRetrait->setUserRetrait($this);
        }

        return $this;
    }

    public function removeTransactionRetrait(Transaction $transactionRetrait): self
    {
        if ($this->transactionRetrait->removeElement($transactionRetrait)) {
            // set the owning side to null (unless already changed)
            if ($transactionRetrait->getUserRetrait() === $this) {
                $transactionRetrait->setUserRetrait(null);
            }
        }

        return $this;
    }
}
