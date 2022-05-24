<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FournisseurRepository::class)
 */
class Fournisseur
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
    private $numFournisseur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emailFournissuer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumFournisseur(): ?string
    {
        return $this->numFournisseur;
    }

    public function setNumFournisseur(string $numFournisseur): self
    {
        $this->numFournisseur = $numFournisseur;

        return $this;
    }

    public function getEmailFournissuer(): ?string
    {
        return $this->emailFournissuer;
    }

    public function setEmailFournissuer(string $emailFournissuer): self
    {
        $this->emailFournissuer = $emailFournissuer;

        return $this;
    }
}
