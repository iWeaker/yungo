<?php

namespace App\Entity;

use App\Repository\InventarioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventarioRepository::class)
 */
class Inventario
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
    private $mac_inventory;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_inventory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model_inventory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $brand_inventory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_inventory;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMacInventory(): ?string
    {
        return $this->mac_inventory;
    }

    public function setMacInventory(string $mac_inventory): self
    {
        $this->mac_inventory = $mac_inventory;

        return $this;
    }

    public function getIdInventory(): ?int
    {
        return $this->id_inventory;
    }

    public function setIdInventory(int $id_inventory): self
    {
        $this->id_inventory = $id_inventory;

        return $this;
    }

    public function getModelInventory(): ?string
    {
        return $this->model_inventory;
    }

    public function setModelInventory(string $model_inventory): self
    {
        $this->model_inventory = $model_inventory;

        return $this;
    }

    public function getBrandInventory(): ?string
    {
        return $this->brand_inventory;
    }

    public function setBrandInventory(string $brand_inventory): self
    {
        $this->brand_inventory = $brand_inventory;

        return $this;
    }

    public function getTypeInventory(): ?string
    {
        return $this->type_inventory;
    }

    public function setTypeInventory(string $type_inventory): self
    {
        $this->type_inventory = $type_inventory;

        return $this;
    }
}
