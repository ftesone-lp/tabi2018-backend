<?php

namespace App\Repository;

use App\Entity\HCosecha;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class HCosechaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HCosecha::class);
    }

    /**
     *
     */
    public function completo()
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT
                    t.decada,
                    e.region,
                    c.cultivo,
                    SUM(h.haSembradas) AS haSembradas,
                    SUM(h.haCosechadas) AS haCosechadas
                FROM App\Entity\HCosecha h
                    JOIN h.idCultivo c
                    JOIN h.idTiempo t
                    JOIN h.idEspacio e
                GROUP BY t.decada, e.region, c.cultivo
                ORDER BY t.decada, e.region, c.cultivo"
            )
            ->execute()
        ;
    }

    /**
     *
     */
    public function region($region)
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT
                    t.decada,
                    e.provincia,
                    c.cultivo,
                    SUM(h.haSembradas) AS haSembradas,
                    SUM(h.haCosechadas) AS haCosechadas
                FROM App\Entity\HCosecha h
                    JOIN h.idCultivo c
                    JOIN h.idTiempo t
                    JOIN h.idEspacio e
                WHERE e.region=:region
                GROUP BY t.decada, e.provincia, c.cultivo
                ORDER BY t.decada, e.provincia, c.cultivo"
            )
            ->setParameter('region', $region)
            ->execute()
        ;
    }
}
