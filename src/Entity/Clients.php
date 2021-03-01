<?php

namespace App\Entity;

use App\Entity\Transaction;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientsRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 * collectionOperations={
 *           "filter_CNI"={
 *              "normalization_context" ={"groups" ={"transactionCNI:read"}},   
 *              "method"="GET",
 *              "path"="/user/client/NCI",
 *             
 *              
 *          },
 *       }
 * )
 * @ORM\Entity(repositoryClass=ClientsRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"numero_cni":"exact"})
 */
class Clients
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"transaction:write","transactionCNI:read"})
     * 
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transactionCNI:read"})
     * 
     */
    private $nomCompletClient;

    /**
     * @Assert\Unique
     * @Assert\NotBlank
     * @Assert\Length(min=9)
     * @Assert\NotNull
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"transaction:write"})
     * @Assert\Unique
     * @Assert\Type(
     *     type="integer",
     *     message="le veleur {{ value }} no valider {{ type }}.")
     * 
     */
    private $numero_cni;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="clients")
     */
    private $transactions;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="clientsRetrait")
     */
    private $transactionsclientsRetrait;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->transactionsclientsRetrait = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCompletClient(): ?string
    {
        return $this->nomCompletClient;
    }

    public function setNomCompletClient(string $nomCompletClient): self
    {
        $this->nomCompletClient = $nomCompletClient;

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

    public function getNumeroCni(): ?string
    {
        return $this->numero_cni;
    }

    public function setNumeroCni(string $numero_cni): self
    {
        $this->numero_cni = $numero_cni;

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
            $transaction->setClients($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getClients() === $this) {
                $transaction->setClients(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return  $this->nomCompletClient;
  
      }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactionsclientsRetrait(): Collection
    {
        return $this->transactionsclientsRetrait;
    }

    public function addTransactionsclientsRetrait(Transaction $transactionsclientsRetrait): self
    {
        if (!$this->transactionsclientsRetrait->contains($transactionsclientsRetrait)) {
            $this->transactionsclientsRetrait[] = $transactionsclientsRetrait;
            $transactionsclientsRetrait->setClientsRetrait($this);
        }

        return $this;
    }

    public function removeTransactionsclientsRetrait(Transaction $transactionsclientsRetrait): self
    {
        if ($this->transactionsclientsRetrait->removeElement($transactionsclientsRetrait)) {
            // set the owning side to null (unless already changed)
            if ($transactionsclientsRetrait->getClientsRetrait() === $this) {
                $transactionsclientsRetrait->setClientsRetrait(null);
            }
        }

        return $this;
    }
}
