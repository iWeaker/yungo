<?php

namespace App\Entity;

use App\Repository\DireccionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToOne(targetEntity=Clientes::class, inversedBy="fkAddress")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clientes;

    /**
     * @ORM\OneToOne(targetEntity=Sitios::class)
     */
    private $fkZone;


    /**
     * @ORM\OneToMany(targetEntity=Servicio::class, mappedBy="fkAddress", cascade={"persist", "remove"})
     */
    private $servicios;

    public function __construct()
    {
        $this->servicios = new ArrayCollection();
    }

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


    /**
     * @return Collection|Servicio[]
     */
    public function getServicios(): Collection
    {
        return $this->servicios;
    }

    public function addServicio(Servicio $servicio): self
    {
        if (!$this->servicios->contains($servicio)) {
            $this->servicios[] = $servicio;
            $servicio->setFkAddress($this);
        }

        return $this;
    }

    public function removeServicio(Servicio $servicio): self
    {
        if ($this->servicios->removeElement($servicio)) {
            // set the owning side to null (unless already changed)
            if ($servicio->getFkAddress() === $this) {
                $servicio->setFkAddress(null);
            }
        }

        return $this;
    }
}
