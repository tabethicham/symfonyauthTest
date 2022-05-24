<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=DevisRepository::class)
 *@UniqueEntity("refDevis")
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
     * @ORM\Column(type="string", length=15, unique=true)
     * @Assert\NotBlank
     * @Assert\Length(max=15)
     */
    
    private $refDevis;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDevis;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3 , max=255)
     * @Assert\NotBlank
     */
    private $messageDevis;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $modalitesPaiementDevis="null";

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $delaiDevis="null";

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="listesDevis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=LignesDevis::class, mappedBy="devis")
     */
    private $lignedevis;

    public function __construct()
    {
        $this->lignedevis = new ArrayCollection();
    }

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

    /**
     * @return Collection|LignesDevis[]
     */
    public function getLignedevis(): Collection
    {
        return $this->lignedevis;
    }

    public function addLignedevi(LignesDevis $lignedevi): self
    {
        if (!$this->lignedevis->contains($lignedevi)) {
            $this->lignedevis[] = $lignedevi;
            $lignedevi->setDevis($this);
        }

        return $this;
    }

    public function removeLignedevi(LignesDevis $lignedevi): self
    {
        if ($this->lignedevis->removeElement($lignedevi)) {
            // set the owning side to null (unless already changed)
            if ($lignedevi->getDevis() === $this) {
                $lignedevi->setDevis(null);
            }
        }

        return $this;
    }
}
