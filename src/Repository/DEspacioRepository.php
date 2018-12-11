<?php

namespace App\Repository;

use App\Entity\DEspacio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DEspacioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DEspacio::class);
    }

    /**
     *
     */
    public function findAllRegiones(): array
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT e.region AS nombre, MIN(e.id) AS id
                FROM App\Entity\DEspacio e
                GROUP BY e.region
                ORDER BY e.region"
            )
            ->execute()
        ;
    }

    /**
     *
     */
    public function findAllProvincias(): array
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT e.provincia AS nombre, MIN(e.id) AS id
                FROM App\Entity\DEspacio e
                GROUP BY e.provincia
                ORDER BY e.provincia"
            )
            ->execute()
        ;
    }
}
