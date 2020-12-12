<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ChatRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 * @ApiResource(
 *       collectionOperations = {
 *          "get" = {
 *              "path" = "/users/promo/{id}/apprenant/{ID}/chats/date"
 *          }
 *       }
 * )
 */
class Chat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"chat:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"chat:read"})
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $pieceJointes;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="chat")
     * @Groups({"chat:read"})
     */
    private $promo;

    /**
     * @ORM\Column(type="date")
     * @Groups({"chat:read"})
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPieceJointes(): ?string
    {
        return $this->pieceJointes;
    }

    public function setPieceJointes(string $pieceJointes): self
    {
        $this->pieceJointes = $pieceJointes;

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
