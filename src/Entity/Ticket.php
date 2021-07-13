<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\ManyToOne(targetEntity=Clientes::class, inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkClient;

    /**
     * @ORM\OneToMany(targetEntity=Comentarios::class, mappedBy="fkTicket")
     */
    private $comentarios;

    public function __construct()
    {
        $this->comentarios = new ArrayCollection();
    }

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

    public function getFkClient(): ?Clientes
    {
        return $this->fkClient;
    }

    public function setFkClient(?Clientes $fkClient): self
    {
        $this->fkClient = $fkClient;

        return $this;
    }

    /**
     * @return Collection|Comentarios[]
     */
    public function getComentarios(): Collection
    {
        return $this->comentarios;
    }

    public function addComentario(Comentarios $comentario): self
    {
        if (!$this->comentarios->contains($comentario)) {
            $this->comentarios[] = $comentario;
            $comentario->setFkTicket($this);
        }

        return $this;
    }

    public function removeComentario(Comentarios $comentario): self
    {
        if ($this->comentarios->removeElement($comentario)) {
            // set the owning side to null (unless already changed)
            if ($comentario->getFkTicket() === $this) {
                $comentario->setFkTicket(null);
            }
        }

        return $this;
    }
}
