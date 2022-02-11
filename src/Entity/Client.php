<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
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
    private $refClient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emailClient;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telClient;

    /**
     * @ORM\OneToMany(targetEntity=Devis::class, mappedBy="client")
     */
    private $listesDevis;

    public function __construct()
    {
        $this->listesDevis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefClient(): ?string
    {
        return $this->refClient;
    }

    public function setRefClient(string $refClient): self
    {
        $this->refClient = $refClient;

        return $this;
    }

    public function getEmailClient(): ?string
    {
        return $this->emailClient;
    }

    public function setEmailClient(string $emailClient): self
    {
        $this->emailClient = $emailClient;

        return $this;
    }

    public function getTelClient(): ?string
    {
        return $this->telClient;
    }

    public function setTelClient(string $telClient): self
    {
        $this->telClient = $telClient;

        return $this;
    }

    /**
     * @return Collection|Devis[]
     */
    public function getListesDevis(): Collection
    {
        return $this->listesDevis;
    }

    public function addListesDevi(Devis $listesDevi): self
    {
        if (!$this->listesDevis->contains($listesDevi)) {
            $this->listesDevis[] = $listesDevi;
            $listesDevi->setClient($this);
        }

        return $this;
    }

    public function removeListesDevi(Devis $listesDevi): self
    {
        if ($this->listesDevis->removeElement($listesDevi)) {
            // set the owning side to null (unless already changed)
            if ($listesDevi->getClient() === $this) {
                $listesDevi->setClient(null);
            }
        }

        return $this;
    }
}
