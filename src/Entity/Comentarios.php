<?php

namespace App\Entity;

use App\Repository\ComentariosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComentariosRepository::class)
 */
class Comentarios
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $comment_comment;

     /**
     * @ORM\Column(type="boolean")
     */
    private $image_comment = false;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt_comment;

    /**
     * @ORM\ManyToOne(targetEntity=Ticket::class, inversedBy="comentarios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkTicket;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentComment(): ?string
    {
        return $this->comment_comment;
    }

    public function setCommentComment(string $comment_comment): self
    {
        $this->comment_comment = $comment_comment;

        return $this;
    }

    public function getImageComment(): ?bool
    {
        return $this->image_comment;
    }

    public function setImageComment(bool $image_comment): self
    {
        $this->image_comment = $image_comment;

        return $this;
    }
    public function getCreatedAtComment(): ?\DateTimeInterface
    {
        return $this->createdAt_comment;
    }

    public function setCreatedAtComment(\DateTimeInterface $createdAt_comment): self
    {
        $this->createdAt_comment = $createdAt_comment;

        return $this;
    }

    public function getFkTicket(): ?Ticket
    {
        return $this->fkTicket;
    }

    public function setFkTicket(?Ticket $fkTicket): self
    {
        $this->fkTicket = $fkTicket;

        return $this;
    }

    
}
