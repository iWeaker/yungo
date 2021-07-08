<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_ticket;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_ticket;

    /**
     * @ORM\Column(type="text")
     */
    private $desc_ticket;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $status_ticket;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeTicket(): ?string
    {
        return $this->type_ticket;
    }

    public function setTypeTicket(string $type_ticket): self
    {
        $this->type_ticket = $type_ticket;

        return $this;
    }

    public function getdateTicket(): ?\DateTimeInterface
    {
        return $this->date_ticket;
    }

    public function setdateTicket(\DateTimeInterface $date_ticket): self
    {
        $this->date_ticket = $date_ticket;

        return $this;
    }

    public function getDescTicket(): ?string
    {
        return $this->desc_ticket;
    }

    public function setDescTicket(string $desc_ticket): self
    {
        $this->desc_ticket = $desc_ticket;

        return $this;
    }

    public function getStatusTicket(): ?string
    {
        return $this->status_ticket;
    }

    public function setStatusTicket(string $status_ticket): self
    {
        $this->status_ticket = $status_ticket;

        return $this;
    }
}
