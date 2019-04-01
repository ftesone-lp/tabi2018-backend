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
        return $this->createQueryBuilder('c')
            ->select('c.id, c.cultivo AS nombre')
            ->where('CURRENT_DATE() BETWEEN c.dateFrom AND c.dateTo')
            ->addOrderBy('c.cultivo', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     *
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return $this->createQueryBuilder('c')
            ->select('c.id, c.cultivo AS nombre')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult()
        ;
    }
}
