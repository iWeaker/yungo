<?php

namespace App\Entity;

use App\Repository\ClientesRepository;
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
     * @ORM\Column(type="string", length=255)
     */
    private $address_client;

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

    public function getAddressClient(): ?string
    {
        return $this->address_client;
    }

    public function setAddressClient(string $address_client): self
    {
        $this->address_client = $address_client;

        return $this;
    }
}
