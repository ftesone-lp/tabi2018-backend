<?php

namespace App\Repository;

use App\Entity\DTiempo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DTiempoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DTiempo::class);
    }

    /**
     *
     */
    public function findAllDecadas(): array
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT t.decada
                FROM App\Entity\DTiempo t
                GROUP BY t.decada
                ORDER BY t.decada"
            )
            ->execute()
        ;
    }
}
