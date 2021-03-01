<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComptesRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateTime;

/**
 * 
 * @ORM\Entity(repositoryClass=ComptesRepository::class)
 *   @ApiResource(
 *  collectionOperations={
 *           "post"={
 *            "path"="/admin/compte",
 *               "denormalization_context" ={"groups" ={"comptes:write"}},  
 *              },
 *       },
 * itemOperations={
 *           "filter_COMPTE"={
 *              "normalization_context" ={"groups" ={"transactioncompte:read"}},   
 *              "method"="GET",
 *              "path"="/admin/compte/{id}/transactions"  ,
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
 *          "caissier_compte"={
 *              "normalization_context" ={"groups" ={"caissier:read"}},   
 *              "method"="GET",
 *              "path"="/caissier/compte/{id} "  ,
 *              "defaults"={"id"=null}
 *             
 *              
 *          },
 *       }
 *
 * )
 *  @ApiFilter(DateFilter::class, properties={"transactions.date_retrait":"exact","transactions.date_depot":"exact"})
 */
class Comptes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"useragence:read","caissier:read","parts:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"transactioncompte:read","comptes:write","useragence:read","caissier:read","parts:read"})
     */
    private $numero_compte;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transactioncompte:read","comptes:write"})
     */
    private $solde;

    /**
     * @ORM\Column(type="date")
     * @Groups({"transactioncompte:read"})
     */
    private $date_creation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

  

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="comptes")
     * @Groups({"transactioncompte:read","parts:read"})
     */
    private $transactions;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="comptesRetrait")
     */
    private $transactionscompteRetrait;

    /**
     * @ORM\OneToOne(targetEntity=Agences::class, inversedBy="comptes", cascade={"persist", "remove"})
     * @Groups({"comptes:write"})
     */
    private $agence;

    public function __construct()
    
    {
        $this->date_creation= new DateTime();
        $this->transactions = new ArrayCollection();
        $this->statut=false;
        $this->transactionscompteRetrait = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numero_compte;
    }

    public function setNumeroCompte(string $numero_compte): self
    {
        $this->numero_compte = $numero_compte;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

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
            $transaction->setComptes($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getComptes() === $this) {
                $transaction->setComptes(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactionscompteRetrait(): Collection
    {
        return $this->transactionscompteRetrait;
    }

    public function addTransactionscompteRetrait(Transaction $transactionscompteRetrait): self
    {
        if (!$this->transactionscompteRetrait->contains($transactionscompteRetrait)) {
            $this->transactionscompteRetrait[] = $transactionscompteRetrait;
            $transactionscompteRetrait->setComptesRetrait($this);
        }

        return $this;
    }

    public function removeTransactionscompteRetrait(Transaction $transactionscompteRetrait): self
    {
        if ($this->transactionscompteRetrait->removeElement($transactionscompteRetrait)) {
            // set the owning side to null (unless already changed)
            if ($transactionscompteRetrait->getComptesRetrait() === $this) {
                $transactionscompteRetrait->setComptesRetrait(null);
            }
        }

        return $this;
    }

    public function getAgence(): ?Agences
    {
        return $this->agence;
    }

    public function setAgence(?Agences $agence): self
    {
        $this->agence = $agence;

        return $this;
    }
}
