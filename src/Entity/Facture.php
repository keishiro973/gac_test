<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
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
    private $reference;

    /**
     * @ORM\Column(type="date")
     */
    private $event_date;

    /**
     * @ORM\Column(type="time")
     */
    private $event_time;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $dduree_reel;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $volume_reel;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $duree_facture;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $volume_facture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_facture;

    /**
     * @ORM\ManyToOne(targetEntity=Abonne::class, inversedBy="factures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $abonne_id;

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
        return $this->event_date;
    }

    public function setEventDate(\DateTimeInterface $event_date): self
    {
        $this->event_date = $event_date;

        return $this;
    }

    public function getEventTime(): ?\DateTimeInterface
    {
        return $this->event_time;
    }

    public function setEventTime(\DateTimeInterface $event_time): self
    {
        $this->event_time = $event_time;

        return $this;
    }

    public function getDdureeReel(): ?\DateTimeInterface
    {
        return $this->dduree_reel;
    }

    public function setDdureeReel(?\DateTimeInterface $dduree_reel): self
    {
        $this->dduree_reel = $dduree_reel;

        return $this;
    }

    public function getVolumeReel(): ?float
    {
        return $this->volume_reel;
    }

    public function setVolumeReel(?float $volume_reel): self
    {
        $this->volume_reel = $volume_reel;

        return $this;
    }

    public function getDureeFacture(): ?\DateTimeInterface
    {
        return $this->duree_facture;
    }

    public function setDureeFacture(?\DateTimeInterface $duree_facture): self
    {
        $this->duree_facture = $duree_facture;

        return $this;
    }

    public function getVolumeFacture(): ?float
    {
        return $this->volume_facture;
    }

    public function setVolumeFacture(?float $volume_facture): self
    {
        $this->volume_facture = $volume_facture;

        return $this;
    }

    public function getTypeFacture(): ?string
    {
        return $this->type_facture;
    }

    public function setTypeFacture(string $type_facture): self
    {
        $this->type_facture = $type_facture;

        return $this;
    }

    public function getAbonneId(): ?Abonne
    {
        return $this->abonne_id;
    }

    public function setAbonneId(?Abonne $abonne_id): self
    {
        $this->abonne_id = $abonne_id;

        return $this;
    }
}
