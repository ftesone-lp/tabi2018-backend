<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HCosecha
 *
 * @ORM\Table(name="h_cosecha", indexes={@ORM\Index(name="fk_tiempo", columns={"id_tiempo"}), @ORM\Index(name="fk_cultivo", columns={"id_cultivo"}), @ORM\Index(name="fk_espacio", columns={"id_espacio"})})
 * @ORM\Entity(repositoryClass="App\Repository\HCosechaRepository")
 */
class HCosecha
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
     * @ORM\Column(name="ha_sembradas", type="integer", nullable=true)
     */
    private $haSembradas;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ha_cosechadas", type="integer", nullable=true)
     */
    private $haCosechadas;

    /**
     * @var int|null
     *
     * @ORM\Column(name="tn_produccion", type="integer", nullable=true)
     */
    private $tnProduccion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="qah_rinde", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $qahRinde;

    /**
     * @var \DCultivo
     *
     * @ORM\ManyToOne(targetEntity="DCultivo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cultivo", referencedColumnName="id")
     * })
     */
    private $idCultivo;

    /**
     * @var \DEspacio
     *
     * @ORM\ManyToOne(targetEntity="DEspacio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_espacio", referencedColumnName="id")
     * })
     */
    private $idEspacio;

    /**
     * @var \DTiempo
     *
     * @ORM\ManyToOne(targetEntity="DTiempo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tiempo", referencedColumnName="anio")
     * })
     */
    private $idTiempo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHaSembradas(): ?int
    {
        return $this->haSembradas;
    }

    public function setHaSembradas(?int $haSembradas): self
    {
        $this->haSembradas = $haSembradas;

        return $this;
    }

    public function getHaCosechadas(): ?int
    {
        return $this->haCosechadas;
    }

    public function setHaCosechadas(?int $haCosechadas): self
    {
        $this->haCosechadas = $haCosechadas;

        return $this;
    }

    public function getTnProduccion(): ?int
    {
        return $this->tnProduccion;
    }

    public function setTnProduccion(?int $tnProduccion): self
    {
        $this->tnProduccion = $tnProduccion;

        return $this;
    }

    public function getQahRinde()
    {
        return $this->qahRinde;
    }

    public function setQahRinde($qahRinde): self
    {
        $this->qahRinde = $qahRinde;

        return $this;
    }

    public function getIdCultivo(): ?DCultivo
    {
        return $this->idCultivo;
    }

    public function setIdCultivo(?DCultivo $idCultivo): self
    {
        $this->idCultivo = $idCultivo;

        return $this;
    }

    public function getIdEspacio(): ?DEspacio
    {
        return $this->idEspacio;
    }

    public function setIdEspacio(?DEspacio $idEspacio): self
    {
        $this->idEspacio = $idEspacio;

        return $this;
    }

    public function getIdTiempo(): ?DTiempo
    {
        return $this->idTiempo;
    }

    public function setIdTiempo(?DTiempo $idTiempo): self
    {
        $this->idTiempo = $idTiempo;

        return $this;
    }
}
