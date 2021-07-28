<?php

namespace App\Entity;

use App\Repository\ClientesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientesRepository::class)
 */
class Clientes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name_client;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email_client;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $phone_client;
    /**
     * @ORM\OneToMany(targetEntity=Ticket::class, mappedBy="fkClient" , cascade={"persist", "remove"})
     */
    private $tickets;

    /**
     * @ORM\OneToMany(targetEntity=Direccion::class, mappedBy="clientes" , cascade={"persist", "remove"})
     */
    private $fkAddress;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->fkAddress = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getNameClient(): ?string
    {
        return $this->name_client;
    }

    public function setNameClient(string $name_client): self
    {
        $this->name_client = $name_client;

        return $this;
    }

    public function getEmailClient(): ?string
    {
        return $this->email_client;
    }

    public function setEmailClient(string $email_client): self
    {
        $this->email_client = $email_client;

        return $this;
    }

    public function getPhoneClient(): ?string
    {
        return $this->phone_client;
    }

    public function setPhoneClient(string $phone_client): self
    {
        $this->phone_client = $phone_client;

        return $this;
    }



    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setFkClient($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getFkClient() === $this) {
                $ticket->setFkClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Direccion[]
     */
    public function getFkAddress(): Collection
    {
        return $this->fkAddress;
    }

    public function addFkAddress(Direccion $fkAddress): self
    {
        if (!$this->fkAddress->contains($fkAddress)) {
            $this->fkAddress[] = $fkAddress;
            $fkAddress->setClientes($this);
        }

        return $this;
    }

    public function removeFkAddress(Direccion $fkAddress): self
    {
        if ($this->fkAddress->removeElement($fkAddress)) {
            // set the owning side to null (unless already changed)
            if ($fkAddress->getClientes() === $this) {
                $fkAddress->setClientes(null);
            }
        }

        return $this;
    }
}
