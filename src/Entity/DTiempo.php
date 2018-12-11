<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DTiempo
 *
 * @ORM\Table(name="d_tiempo")
 * @ORM\Entity(repositoryClass="App\Repository\DTiempoRepository")
 */
class DTiempo
{
    /**
     * @var int
     *
     * @ORM\Column(name="anio", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $anio;

    /**
     * @var int|null
     *
     * @ORM\Column(name="decada", type="integer", nullable=true)
     */
    private $decada;

    public function getAnio(): ?int
    {
        return $this->anio;
    }

    public function getDecada(): ?int
    {
        return $this->decada;
    }

    public function setDecada(?int $decada): self
    {
        $this->decada = $decada;

        return $this;
    }
}
