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
    public function datosCompletos($tiempo = null, $region = null, $provincia = null)
    {
        $queryBuilder = $this->createQueryBuilder('h');

        $fields = [
            $tiempo ? 't.anio' : 't.decada',
            $provincia ? 'e.departamento' : ($region ? 'e.provincia' : 'e.region'),
            'c.cultivo',
        ];

        $queryBuilder
            ->select(implode(',', array_merge($fields, ['SUM(h.haSembradas) AS haSembradas', 'SUM(h.haCosechadas) AS haCosechadas'])))
            ->innerJoin('h.idCultivo', 'c')
            ->innerJoin('h.idTiempo', 't')
            ->innerJoin('h.idEspacio', 'e')
        ;

        if ($tiempo) {
            $queryBuilder
                ->andWhere('t.decada = :decada')
                ->setParameter('decada', $tiempo)
            ;
        }

        if ($provincia) {
            $queryBuilder
                ->andWhere('e.provincia = :provincia')
                ->setParameter('provincia', $provincia)
            ;
        } elseif ($region) {
            $queryBuilder
                ->andWhere('e.region = :region')
                ->setParameter('region', $region)
            ;
        }

        foreach ($fields as $field) {
            $queryBuilder
                ->addGroupBy($field)
                ->addOrderBy($field, 'ASC')
            ;
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     *
     */
    public function datosCultivo($cultivo, $tiempo = null, $region = null, $provincia = null)
    {
        $queryBuilder = $this->createQueryBuilder('h');

        $fields = [
            $tiempo ? 't.anio' : 't.decada',
            $provincia ? 'e.departamento' : ($region ? 'e.provincia' : 'e.region'),
        ];

        $queryBuilder
            ->select(implode(',', array_merge($fields, [
                'SUM(h.haSembradas) AS haSembradas',
                'SUM(h.haCosechadas) AS haCosechadas',
                'SUM(h.tnProduccion) AS tnProduccion',
                'SUM(h.qahRinde) AS qahRinde',
            ])))
            ->innerJoin('h.idTiempo', 't')
            ->innerJoin('h.idEspacio', 'e')
            ->where('h.idCultivo=:idCultivo')
            ->setParameter('idCultivo', $cultivo)
        ;

        if ($tiempo) {
            $queryBuilder
                ->andWhere('t.decada = :decada')
                ->setParameter('decada', $tiempo)
            ;
        }

        if ($provincia) {
            $queryBuilder
                ->andWhere('e.provincia = :provincia')
                ->setParameter('provincia', $provincia)
            ;
        } elseif ($region) {
            $queryBuilder
                ->andWhere('e.region = :region')
                ->setParameter('region', $region)
            ;
        }

        foreach ($fields as $field) {
            $queryBuilder
                ->addGroupBy($field)
                ->addOrderBy($field, 'ASC')
            ;
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
