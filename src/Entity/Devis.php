<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DevisRepository::class)
 */
class Devis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $refDevis;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDevis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $messageDevis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modalitesPaiementDevis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $delaiDevis;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="listesDevis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefDevis(): ?string
    {
        return $this->refDevis;
    }

    public function setRefDevis(string $refDevis): self
    {
        $this->refDevis = $refDevis;

        return $this;
    }

    public function getDateDevis(): ?\DateTimeInterface
    {
        return $this->dateDevis;
    }

    public function setDateDevis(\DateTimeInterface $dateDevis): self
    {
        $this->dateDevis = $dateDevis;

        return $this;
    }

    public function getMessageDevis(): ?string
    {
        return $this->messageDevis;
    }

    public function setMessageDevis(string $messageDevis): self
    {
        $this->messageDevis = $messageDevis;

        return $this;
    }

    public function getModalitesPaiementDevis(): ?string
    {
        return $this->modalitesPaiementDevis;
    }

    public function setModalitesPaiementDevis(string $modalitesPaiementDevis): self
    {
        $this->modalitesPaiementDevis = $modalitesPaiementDevis;

        return $this;
    }

    public function getDelaiDevis(): ?string
    {
        return $this->delaiDevis;
    }

    public function setDelaiDevis(string $delaiDevis): self
    {
        $this->delaiDevis = $delaiDevis;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
