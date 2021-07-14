<?php

namespace App\Entity;

use App\Repository\DireccionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DireccionRepository::class)
 */
class Direccion
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
    private $name_address;

    /**
     * @ORM\OneToOne(targetEntity=Paquete::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkPacket;

    /**
     * @ORM\ManyToOne(targetEntity=Clientes::class, inversedBy="fkAddress")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clientes;

    /**
     * @ORM\OneToOne(targetEntity=Sitios::class, cascade={"persist", "remove"})
     */
    private $fkZone;

    /**
     * @ORM\OneToOne(targetEntity=Inventario::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkInventary;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameAddress(): ?string
    {
        return $this->name_address;
    }

    public function setNameAddress(string $name_address): self
    {
        $this->name_address = $name_address;

        return $this;
    }

    public function getFkPacket(): ?Paquete
    {
        return $this->fkPacket;
    }

    public function setFkPacket(Paquete $fkPacket): self
    {
        $this->fkPacket = $fkPacket;

        return $this;
    }

    public function getClientes(): ?Clientes
    {
        return $this->clientes;
    }

    public function setClientes(?Clientes $clientes): self
    {
        $this->clientes = $clientes;

        return $this;
    }

    public function getFkZone(): ?Sitios
    {
        return $this->fkZone;
    }

    public function setFkZone(?Sitios $fkZone): self
    {
        $this->fkZone = $fkZone;

        return $this;
    }

    public function getFkInventary(): ?Inventario
    {
        return $this->fkInventary;
    }

    public function setFkInventary(Inventario $fkInventary): self
    {
        $this->fkInventary = $fkInventary;

        return $this;
    }
}
