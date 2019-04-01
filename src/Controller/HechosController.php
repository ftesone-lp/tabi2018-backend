<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\DCultivo;
use App\Entity\DEspacio;
use App\Entity\DTiempo;
use App\Entity\HCosecha;

class HechosController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function datosCompleto(Request $request)
    {
        $doctrine = $this->getDoctrine();

        $dimensiones = [];

        $filtros = [
            'tiempo'    => $request->query->get('decada'),
            'region'    => $request->query->get('region'),
            'provincia' => $request->query->get('provincia'),
        ];

        // filtro espacio
        if ($filtros['region']) {
            $filtros['region'] = $doctrine->getRepository(DEspacio::class)->findRegionById($filtros['region']);
            $espacio = $doctrine->getRepository(DEspacio::class)->findAllProvinciasByRegion($filtros['region']);
            $dimensiones['espacio'] = 'provincia';
        } elseif ($filtros['provincia']) {
            $filtros['provincia'] = $doctrine->getRepository(DEspacio::class)->findProvinciaById($filtros['provincia']);
            $espacio = $doctrine->getRepository(DEspacio::class)->findAllDepartamentosByProvincia($filtros['provincia']);
            $dimensiones['espacio'] = 'departamento';
        } else {
            $espacio = $doctrine->getRepository(DEspacio::class)->findAllRegiones();
            $dimensiones['espacio'] = 'region';
        }
        $espacio = array_column($espacio, 'nombre');

        // filtro tiempo
        if ($filtros['tiempo']) {
            $tiempo = $doctrine->getRepository(DTiempo::class)->findAllAniosByDecada($filtros['tiempo']);
            $tiempo = array_column($tiempo, 'anio');
            $dimensiones['tiempo'] = 'anio';
        } else {
            $tiempo = $doctrine->getRepository(DTiempo::class)->findAllDecadas();
            $tiempo = array_column($tiempo, 'decada');
            $dimensiones['tiempo'] = 'decada';
        }

        $cultivos = $doctrine->getRepository(DCultivo::class)->findAll();
        $cultivos = array_column($cultivos, 'nombre');

        $estructura = $this->construirEstructura($tiempo, $espacio, $cultivos, ['haSembradas' => 0, 'haCosechadas' => 0]);

        $medidas = $doctrine->getRepository(HCosecha::class)->datosCompletos($filtros['tiempo'], $filtros['region'], $filtros['provincia']);

        foreach ($medidas as $medida) {
            $estructura[$medida[$dimensiones['tiempo']]][$medida[$dimensiones['espacio']]][$medida['cultivo']]['haSembradas']  = (int) $medida['haSembradas'];
            $estructura[$medida[$dimensiones['tiempo']]][$medida[$dimensiones['espacio']]][$medida['cultivo']]['haCosechadas'] = (int) $medida['haCosechadas'];
        }

        return new JsonResponse($this->construirDatos($estructura, ['haSembradas', 'haCosechadas']));
    }

    /**
     * @Route("/cultivo/{id}")
     */
    public function datosCultivo(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();

        $dimensiones = [];

        $filtros = [
            'tiempo'    => $request->query->get('decada'),
            'region'    => $request->query->get('region'),
            'provincia' => $request->query->get('provincia'),
        ];

        // filtro espacio
        if ($filtros['region']) {
            $filtros['region'] = $doctrine->getRepository(DEspacio::class)->findRegionById($filtros['region']);
            $espacio = $doctrine->getRepository(DEspacio::class)->findAllProvinciasByRegion($filtros['region']);
            $dimensiones['espacio'] = 'provincia';
        } elseif ($filtros['provincia']) {
            $filtros['provincia'] = $doctrine->getRepository(DEspacio::class)->findProvinciaById($filtros['provincia']);
            $espacio = $doctrine->getRepository(DEspacio::class)->findAllDepartamentosByProvincia($filtros['provincia']);
            $dimensiones['espacio'] = 'departamento';
        } else {
            $espacio = $doctrine->getRepository(DEspacio::class)->findAllRegiones();
            $dimensiones['espacio'] = 'region';
        }
        $espacio = array_column($espacio, 'nombre');

        // filtro tiempo
        if ($filtros['tiempo']) {
            $tiempo = $doctrine->getRepository(DTiempo::class)->findAllAniosByDecada($filtros['tiempo']);
            $tiempo = array_column($tiempo, 'anio');
            $dimensiones['tiempo'] = 'anio';
        } else {
            $tiempo = $doctrine->getRepository(DTiempo::class)->findAllDecadas();
            $tiempo = array_column($tiempo, 'decada');
            $dimensiones['tiempo'] = 'decada';
        }

        $cultivo = $doctrine->getRepository(DCultivo::class)->find($id);

        // $decadas = $doctrine->getRepository(DTiempo::class)->findAllDecadas();
        // $decadas = array_column($decadas, 'decada');

        // $regiones = $doctrine->getRepository(DEspacio::class)->findAllRegiones();
        // $regiones = array_column($regiones, 'nombre');

        $medidasEstructura = ['haSembradas', 'haCosechadas', 'tnProduccion', 'qahRinde'];

        $estructura = $this->construirEstructura($tiempo, $espacio, ['haSembradas' => 0, 'haCosechadas' => 0, 'tnProduccion' => 0, 'qahRinde' => 0]);

        $medidas = $doctrine->getRepository(HCosecha::class)->datosCultivo($cultivo['id'], $filtros['tiempo'], $filtros['region'], $filtros['provincia']);

        foreach ($medidas as $medida) {
            foreach ($medidasEstructura as $medidaEstructura) {
                $estructura[$medida[$dimensiones['tiempo']]][$medida[$dimensiones['espacio']]][$medidaEstructura] = (int) $medida[$medidaEstructura];
            }
        }

        return new JsonResponse($this->construirDatos($estructura, ['data']));
    }

    /**
     *
     */
    protected function construirEstructura(array $dimension1, array $dimension2, array $dimension3, array $medidas = null)
    {
        $estructura = [];

        if ($medidas) {
            foreach ($dimension1 as $d1) {
                $estructura[$d1] = [];

                foreach ($dimension2 as $d2) {
                    $estructura[$d1][$d2] = [];

                    foreach ($dimension3 as $d3) {
                        $estructura[$d1][$d2][$d3] = $medidas;
                    }
                }
            }
        } else {
            foreach ($dimension1 as $d1) {
                $estructura[$d1] = [];

                foreach ($dimension2 as $d2) {
                    $estructura[$d1][$d2] = $dimension3;
                }
            }
        }

        return $estructura;
    }

    /**
     *
     */
    protected function construirDatos(array $datos, array $medidas)
    {
        $x = [];

        $datosMedidas = [];

        foreach ($medidas as $medida) {
            $datosMedidas[$medida] = [];
        }

        foreach ($datos as $tiempo => $dato) {
            foreach ($dato as $espacio => $datoCultivo) {
                $tiempoEspacio = sprintf('%s %d', $espacio, $tiempo);

                if (!in_array($tiempoEspacio, $x)) {
                    $x []= $tiempoEspacio;
                }

                $keys = array_keys($datoCultivo);
                if (is_array($datoCultivo[$keys[0]])) {
                    foreach ($datoCultivo as $cultivo => $data) {
                        foreach ($medidas as $medida) {
                            if (!isset($datosMedidas[$medida][$cultivo])) {
                                $datosMedidas[$medida][$cultivo] = [
                                            'name' => $cultivo,
                                            'data' => [],
                                        ];
                            }

                            $datosMedidas[$medida][$cultivo]['data'] []= $data[$medida];
                        }
                    }
                } else {
                    foreach ($datoCultivo as $medida => $data) {
                        if (!isset($datosMedidas['data'][$medida])) {
                            $datosMedidas['data'][$medida] = [
                                'name' => $medida,
                                'data' => [],
                            ];
                        }

                        $datosMedidas['data'][$medida]['data'] []= $data;
                    }
                }
            }
        }

        $response = [
            'x' => $x,
        ];

        foreach ($medidas as $medida) {
            $response[$medida] = array_values($datosMedidas[$medida]);
        }

        return $response;
    }
}
