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
    public function findAllDecadas():array
    {
        return $this->createQueryBuilder('t')
            ->select('t.decada')
            ->addGroupBy('t.decada')
            ->addOrderBy('t.decada', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     *
     */
    public function findAllAniosByDecada($decada):array
    {
        return $this->createQueryBuilder('t')
            ->select('t.anio')
            ->andWhere('t.decada = :decada')
            ->setParameter('decada', $decada)
            ->addOrderBy('t.anio', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
