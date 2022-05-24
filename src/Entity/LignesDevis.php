<?php

namespace App\Entity;

use App\Repository\LignesDevisRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=LignesDevisRepository::class)
 */
class LignesDevis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("lignesDevis:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("lignesDevis:read")
     * @Assert\NotNull
     * @Assert\Length(max=255)
     */
    private $designation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("lignesDevis:read")
     * @Assert\NotNull
     * @Assert\Length(max=255)
     * @Assert\Positive
     */
    private $quantite;

    /**
     * @ORM\Column(type="float")
     * @Groups("lignesDevis:read")
     * @Assert\NotNull
     * @Assert\Length(max=255)
     * @Assert\Positive
     */
    private $prixUnitHT;

    /**
     * @ORM\ManyToOne(targetEntity=Devis::class, inversedBy="lignedevis")
     */
    private $devis;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixUnitHT(): ?float
    {
        return $this->prixUnitHT;
    }

    public function setPrixUnitHT(float $prixUnitHT): self
    {
        $this->prixUnitHT = $prixUnitHT;

        return $this;
    }

    public function getDevis(): ?Devis
    {
        return $this->devis;
    }

    public function setDevis(?Devis $devis): self
    {
        $this->devis = $devis;

        return $this;
    }
}
