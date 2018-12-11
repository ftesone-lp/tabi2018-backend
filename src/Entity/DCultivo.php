<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DCultivo
 *
 * @ORM\Table(name="d_cultivo", indexes={@ORM\Index(name="idx_d_cultivo_lookup", columns={"id_original"}), @ORM\Index(name="idx_d_cultivo_tk", columns={"id"})})
 * @ORM\Entity(repositoryClass="App\Repository\DCultivoRepository")
 */
class DCultivo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="version", type="integer", nullable=true)
     */
    private $version;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_from", type="datetime", nullable=true)
     */
    private $dateFrom;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_to", type="datetime", nullable=true)
     */
    private $dateTo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_original", type="bigint", nullable=true)
     */
    private $idOriginal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cultivo", type="string", length=100, nullable=true)
     */
    private $cultivo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(?int $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getDateFrom(): ?\DateTimeInterface
    {
        return $this->dateFrom;
    }

    public function setDateFrom(?\DateTimeInterface $dateFrom): self
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    public function getDateTo(): ?\DateTimeInterface
    {
        return $this->dateTo;
    }

    public function setDateTo(?\DateTimeInterface $dateTo): self
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    public function getIdOriginal(): ?int
    {
        return $this->idOriginal;
    }

    public function setIdOriginal(?int $idOriginal): self
    {
        $this->idOriginal = $idOriginal;

        return $this;
    }

    public function getCultivo(): ?string
    {
        return $this->cultivo;
    }

    public function setCultivo(?string $cultivo): self
    {
        $this->cultivo = $cultivo;

        return $this;
    }
}
