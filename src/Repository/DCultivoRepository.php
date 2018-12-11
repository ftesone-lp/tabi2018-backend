<?php

namespace App\Repository;

use App\Entity\DCultivo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DCultivoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DCultivo::class);
    }

    /**
     *
     */
    public function findAll(): array
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT c.id, c.cultivo AS nombre
                FROM App\Entity\DCultivo c
                WHERE CURRENT_DATE() BETWEEN c.dateFrom AND c.dateTo
                ORDER BY c.cultivo"
            )
            ->execute()
        ;
    }
}
