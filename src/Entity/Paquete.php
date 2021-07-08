<?php

namespace App\Entity;

use App\Repository\PaqueteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaqueteRepository::class)
 */
class Paquete
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
    private $name_packet;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity_packet;

    /**
     * @ORM\Column(type="float")
     */
    private $price_packet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamePacket(): ?string
    {
        return $this->name_packet;
    }

    public function setNamePacket(string $name_packet): self
    {
        $this->name_packet = $name_packet;

        return $this;
    }

    public function getCapacityPacket(): ?int
    {
        return $this->capacity_packet;
    }

    public function setCapacityPacket(int $capacity_packet): self
    {
        $this->capacity_packet = $capacity_packet;

        return $this;
    }

    public function getPricePacket(): ?float
    {
        return $this->price_packet;
    }

    public function setPricePacket(float $price_packet): self
    {
        $this->price_packet = $price_packet;

        return $this;
    }
}
