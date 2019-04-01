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
        return $this->createQueryBuilder('e')
            ->select('e.region AS nombre, MIN(e.id) AS id')
            ->addGroupBy('e.region')
            ->addOrderBy('e.region', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     *
     */
    public function findAllProvincias(): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.provincia AS nombre, MIN(e.id) AS id')
            ->addGroupBy('e.provincia')
            ->addOrderBy('e.provincia', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     *
     */
    public function findRegionById($id)
    {
        return $this->createQueryBuilder('e')
            ->select('e.region')
            ->where('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
     *
     */
    public function findAllProvinciasByRegion($region)
    {
        return $this->createQueryBuilder('e')
            ->select('e.provincia AS nombre, MIN(e.id) AS id')
            ->where('e.region = :region')
            ->setParameter('region', $region)
            ->addGroupBy('e.provincia')
            ->addOrderBy('e.provincia', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     *
     */
    public function findProvinciaById($id)
    {
        return $this->createQueryBuilder('e')
            ->select('e.provincia')
            ->where('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
     *
     */
    public function findAllDepartamentosByProvincia($provincia)
    {
        return $this->createQueryBuilder('e')
            ->select('e.departamento AS nombre, e.id')
            ->where('e.provincia = :provincia')
            ->setParameter('provincia', $provincia)
            ->getQuery()
            ->getResult()
        ;
    }
}
