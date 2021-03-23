<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransactionRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @ApiResource(
 *  collectionOperations={
 * 
 *         "post_transaction"={
 *              "normalization_context" ={"groups" ={"transaction:read"}},
 *              "method"="POST",
 *              "path"="/user/transactions",
 *              "denormalization_context" ={"groups" ={"transaction:write"}},
 *              
 *          },
 *          "filter_transaction_code"={
 *              "normalization_context" ={"groups" ={"transactionuser:read"}},  
 *              "method"="GET",
 *              "path"="/user/transactions/code",
 *             
 *              
 *          },
 *          "filter_transaction_montant"={
 *              "normalization_context" ={"groups" ={"transactionmontant:read"}},  
 *              "method"="GET",
 *              "path"="/user/transactions/montant",
 *             
 *              
 *          },
 *          
 *          
 *       },
 *      itemOperations={
 *          
 *    "put_transactin"={
 *              "method"="PUT",
 *              "path"="/user/transactions/{id}",
 *              "denormalization_context" ={"groups" ={"transactionretrait:write"}},
 *              
 *          },
 *    "getuser"={
 *              "normalization_context" ={"groups" ={"transactioniduser:read"}},     
 *              "method"="GET",
 *              "path"="/user/transactions",
 *              
 * 
 * 
 *          },
 * 
 *       
 *               
 *    }
 * )    
 * @ApiFilter(SearchFilter::class, properties={"code_transaction":"exact","user.id":"exact","userRetrait.id":"exact","montant":"exact"})
 * @ApiFilter(DateFilter::class, properties={"date_depot","date_retrait"})
 * 
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"transactionuser:read","transactionretrait:write","transactionretrait:write","transactionmontant:read"})
     * @Groups({"transactioncompte:read","getRetraitTransByIdUser","getDepotTransByIdUser","transactioniduser:read","parts:read","transactionuser:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction:write","transactionmontant:read"})
     * @Groups({"transactioncompte:read","getDepotTransByIdUser","getRetraitTransByIdUser","transactioniduser:read","transactionuser:read"})
     */
    private $montant;

    /**
     * @ORM\Column(type="date",nullable=true)
     * @Groups({"transactionuser:read"})
     * @Groups({"transactioncompte:read","getDepotTransByIdUser","transactioniduser:read","transactionuser:read"})
     * 
     */
    private $date_depot;

    /**
     * @ORM\Column(type="date",nullable=true)
     * @Groups({"transactionuser:read"})
     * @Groups({"transactioncompte:read","getDepotTransByIdUser","transactioniduser:read","transactionuser:read"})
     */
    private $date_retrait;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"transactionretrait:write","getRetraitTransByIdUser","getDepotTransByIdUser","transactioniduser:read","transactionuser:read"})
     * 
     */
    private $code_transaction;

    /**
     * @ORM\Column(type="integer",nullable=true)
     *  @Groups({"transactionmontant:read"})
     * @Groups({"transactioncompte:read","getRetraitTransByIdUser","getDepotTransByIdUser","getDepotTransByIdUser","transactioniduser:read","transactionuser:read"})
     */
    private $frais;

    /**
     * @ORM\Column(type="integer",nullable=true)
     * @Groups({"transaction:write"})
     * @Groups({"transactionmontant:read"})
     * @Groups({"transactioncompte:read","transactioniduser:read","transactionuser:read"})
     */
    private $frais_depot;

    /**
     * @ORM\Column(type="integer",nullable=true)
     * @Groups({"transaction:write"})
     * @Groups({"transactionmontant:read"})
     * @Groups({"transactioncompte:read","getRetraitTransByIdUser","transactioniduser:read","transactionuser:read"})
     */
    private $frais_retrait;

    /**
     * @ORM\Column(type="integer",nullable=true)
     * @Groups({"transaction:write"})
     * @Groups({"transactionmontant:read"})
     * @Groups({"transactioncompte:read","transactioniduser:read","transactionuser:read"})
     */
    private $frais_etat;

    /**
     * @ORM\Column(type="integer",nullable=true)
     * @Groups({"transactionmontant:read"})
     * @Groups({"transactioncompte:read","transactioniduser:read","transactionuser:read"})
     */
    private $frais_system;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactions")
     * @Groups({"transaction:write","getDepotTransByIdUser","getRetraitTransByIdUser"})
     *
     *
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Comptes::class, inversedBy="transactions")
     * 
     */
    private $comptes;

    /**
     * @ORM\ManyToOne(targetEntity=Clients::class, inversedBy="transactions",cascade={"persist"})
     *  @Groups({"transaction:write","transactionCNI:read","transactionuser:read"})
     * 
     */
    private $clients;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactionRetrait")
     * @Groups({"transaction:write","getRetraitTransByIdUser","transactionuser:read"})
     */
    private $userRetrait;

    /**
     * @ORM\ManyToOne(targetEntity=Clients::class, inversedBy="transactionsclientsRetrait",cascade={"persist"})
     * @Groups({"transaction:write","getRetraitTransByIdUser","transactionCNI:read","transactionuser:read"})
     */
    private $clientsRetrait;

    /**
     * 
     * @ORM\ManyToOne(targetEntity=Comptes::class, inversedBy="transactionscompteRetrait")
     *  @Groups({"transaction:write"})
     */
    private $comptesRetrait;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *  @Groups({"transactionuser:read","getRetraitTransByIdUser"})
     */
    private $isRetired;

    public function __construct()
    {
        $this->date_depot=new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->date_depot;
    }

    public function setDateDepot(\DateTimeInterface $date_depot): self
    {
        $this->date_depot = $date_depot;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->date_retrait;
    }

    public function setDateRetrait(\DateTimeInterface $date_retrait): self
    {
        $this->date_retrait = $date_retrait;

        return $this;
    }

    public function getCodeTransaction(): ?string
    {
        return $this->code_transaction;
    }

    public function setCodeTransaction(string $code_transaction): self
    {
        $this->code_transaction = $code_transaction;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getFraisDepot(): ?int
    {
        return $this->frais_depot;
    }

    public function setFraisDepot(int $frais_depot): self
    {
        $this->frais_depot = $frais_depot;

        return $this;
    }

    public function getFraisRetrait(): ?int
    {
        return $this->frais_retrait;
    }

    public function setFraisRetrait(int $frais_retrait): self
    {
        $this->frais_retrait = $frais_retrait;

        return $this;
    }

    public function getFraisEtat(): ?int
    {
        return $this->frais_etat;
    }

    public function setFraisEtat(int $frais_etat): self
    {
        $this->frais_etat = $frais_etat;

        return $this;
    }

    public function getFraisSystem(): ?int
    {
        return $this->frais_system;
    }

    public function setFraisSystem(int $frais_system): self
    {
        $this->frais_system = $frais_system;

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

    public function getComptes(): ?Comptes
    {
        return $this->comptes;
    }

    public function setComptes(?Comptes $comptes): self
    {
        $this->comptes = $comptes;

        return $this;
    }

    public function getClients(): ?Clients
    {
        return $this->clients;
    }

    public function setClients(?Clients $clients): self
    {
        $this->clients = $clients;

        return $this;
    }
    public function __toString(){
        return  $this->comptes;
  
      }

    public function getUserRetrait(): ?User
    {
        return $this->userRetrait;
    }

    public function setUserRetrait(?User $userRetrait): self
    {
        $this->userRetrait = $userRetrait;

        return $this;
    }

    public function getClientsRetrait(): ?Clients
    {
        return $this->clientsRetrait;
    }

    public function setClientsRetrait(?Clients $clientsRetrait): self
    {
        $this->clientsRetrait = $clientsRetrait;

        return $this;
    }

    public function getComptesRetrait(): ?Comptes
    {
        return $this->comptesRetrait;
    }

    public function setComptesRetrait(?Comptes $comptesRetrait): self
    {
        $this->comptesRetrait = $comptesRetrait;

        return $this;
    }

    public function getIsRetired(): ?bool
    {
        return $this->isRetired;
    }

    public function setIsRetired(?bool $isRetired): self
    {
        $this->isRetired = $isRetired;

        return $this;
    }
}
