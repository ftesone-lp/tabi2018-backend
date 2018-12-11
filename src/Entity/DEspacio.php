<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DEspacio
 *
 * @ORM\Table(name="d_espacio", uniqueConstraints={@ORM\UniqueConstraint(name="idx_d_espacio_pk", columns={"id"})}, indexes={@ORM\Index(name="idx_d_espacio_lookup", columns={"departamento", "provincia", "region"})})
 * @ORM\Entity(repositoryClass="App\Repository\DEspacioRepository")
 */
class DEspacio
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
     * @var string|null
     *
     * @ORM\Column(name="departamento", type="string", length=100, nullable=true)
     */
    private $departamento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="provincia", type="string", length=20, nullable=true)
     */
    private $provincia;

    /**
     * @var string|null
     *
     * @ORM\Column(name="region", type="string", length=10, nullable=true)
     */
    private $region;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartamento(): ?string
    {
        return $this->departamento;
    }

    public function setDepartamento(?string $departamento): self
    {
        $this->departamento = $departamento;

        return $this;
    }

    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    public function setProvincia(?string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }
}
