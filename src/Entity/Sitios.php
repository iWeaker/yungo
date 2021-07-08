<?php

namespace App\Entity;

use App\Repository\SitiosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SitiosRepository::class)
 */
class Sitios
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
    private $zone_place;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZonePlace(): ?string
    {
        return $this->zone_place;
    }

    public function setZonePlace(string $zone_place): self
    {
        $this->zone_place = $zone_place;

        return $this;
    }
}
