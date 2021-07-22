<?php

namespace App\Entity;

use App\Repository\ServicioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;

/**
 * @ORM\Entity(repositoryClass=ServicioRepository::class)
 */
class Servicio
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Direccion::class, inversedBy="servicios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkAddress;

    /**
     * @ORM\OneToOne(targetEntity=Paquete::class, cascade={"persist", "remove"})
     */
    private $fkPacket;

    /**
     * @ORM\OneToOne(targetEntity=Inventario::class, inversedBy="servicio", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkInventary;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkAddress(): ?Direccion
    {
        return $this->fkAddress;
    }

    public function setFkAddress(?Direccion $fkAddress): self
    {
        $this->fkAddress = $fkAddress;

        return $this;
    }

    public function getFkPacket(): ?Paquete
    {
        return $this->fkPacket;
    }

    public function setFkPacket(?Paquete $fkPacket): self
    {
        $this->fkPacket = $fkPacket;

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
