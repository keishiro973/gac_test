<?php
declare(strict_types = 1);

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
{
    const SMS = 1;
    const CALL = 2;
    const INTERNET = 3;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="date")
     */
    private $eventDate;

    /**
     * @ORM\Column(type="time")
     */
    private $eventTime;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $dureeReel;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $volumeReel;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $dureeFacture;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $volumeFacture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeFacture;

    /**
     * @ORM\ManyToOne(targetEntity=Abonne::class, inversedBy="factures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $abonne;

    /**
     * @ORM\Column(type="integer")
     */
    private $connectionType;

    /**
     * @ORM\ManyToOne(targetEntity=Compte::class, inversedBy="facture_id")
     */
    private $compte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getEventDate(): ?\DateTimeInterface
    {
        return $this->eventDate;
    }

    public function setEventDate(\DateTimeInterface $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getEventTime(): ?\DateTimeInterface
    {
        return $this->eventTime;
    }

    public function setEventTime(\DateTimeInterface $eventTime): self
    {
        $this->eventTime = $eventTime;

        return $this;
    }

    public function getDureeReel(): ?\DateTimeInterface
    {
        return $this->dureeReel;
    }

    public function setDureeReel(?\DateTimeInterface $dureeReel): self
    {
        $this->dureeReel = $dureeReel;

        return $this;
    }

    public function getVolumeReel(): ?float
    {
        return $this->volumeReel;
    }

    public function setVolumeReel(?float $volumeReel): self
    {
        $this->volumeReel = $volumeReel;

        return $this;
    }

    public function getDureeFacture(): ?\DateTimeInterface
    {
        return $this->dureeFacture;
    }

    public function setDureeFacture(?\DateTimeInterface $dureeFacture): self
    {
        $this->dureeFacture = $dureeFacture;

        return $this;
    }

    public function getVolumeFacture(): ?float
    {
        return $this->volumeFacture;
    }

    public function setVolumeFacture(?float $volumeFacture): self
    {
        $this->volumeFacture = $volumeFacture;

        return $this;
    }

    public function getTypeFacture(): ?string
    {
        return $this->typeFacture;
    }

    public function setTypeFacture(string $typeFacture): self
    {
        $this->typeFacture = $typeFacture;

        return $this;
    }

    public function getAbonne(): ?Abonne
    {
        return $this->abonne;
    }

    public function setAbonne(?Abonne $abonne): self
    {
        $this->abonne = $abonne;

        return $this;
    }

    public function getConnectionType(): ?int
    {
        return $this->connectionType;
    }

    public function setConnectionType(int $connectionType): self
    {
        $this->connectionType = $connectionType;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }
}
