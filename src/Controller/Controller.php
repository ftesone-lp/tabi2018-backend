<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\DCultivo;
use App\Entity\DEspacio;
use App\Entity\DTiempo;
use App\Entity\HCosecha;

class Controller extends AbstractController
{
    /**
     * @Route("/regiones")
     */
    public function regiones()
    {
        return new JsonResponse($this->getDoctrine()->getRepository(DEspacio::class)->findAllRegiones());
    }

    /**
     * @Route("/provincias")
     */
    public function provincias()
    {
        return new JsonResponse($this->getDoctrine()->getRepository(DEspacio::class)->findAllProvincias());
    }

    /**
     * @Route("/cultivos")
     */
    public function cultivos()
    {
        return new JsonResponse($this->getDoctrine()->getRepository(DCultivo::class)->findAll());
    }

    /**
     * @Route("/decadas")
     */
    public function decadas()
    {
        return new JsonResponse($this->getDoctrine()->getRepository(DTiempo::class)->findAllDecadas());
    }

    /**
     * @Route("/")
     */
    public function completo()
    {
        $doctrine = $this->getDoctrine();

        $decadas = $doctrine->getRepository(DTiempo::class)->findAllDecadas();

        $regiones = $doctrine->getRepository(DEspacio::class)->findAllRegiones();

        $cultivos = $doctrine->getRepository(DCultivo::class)->findAll();

        $datos = [];

        foreach ($decadas as $decada) {
            $decada = $decada['decada'];
            $datos[$decada] = [];

            foreach ($regiones as $region) {
                $region = $region['nombre'];
                $datos[$decada][$region] = [];

                foreach ($cultivos as $cultivo) {
                    $cultivo = $cultivo['nombre'];
                    $datos[$decada][$region][$cultivo] = [
                        'haSembradas'  => 0,
                        'haCosechadas' => 0,
                    ];
                }
            }
        }

        $medidas = $this->getDoctrine()->getRepository(HCosecha::class)->completo();

        foreach ($medidas as $medida) {
            $datos[$medida['decada']][$medida['region']][$medida['cultivo']]['haSembradas']  = (int) $medida['haSembradas'];
            $datos[$medida['decada']][$medida['region']][$medida['cultivo']]['haCosechadas'] = (int) $medida['haCosechadas'];
        }

        $x = [];

        $haSembradas  = [];
        $haCosechadas = [];

        foreach ($datos as $decada => $dato) {
            foreach ($dato as $region => $datoCultivo) {
                $decadaRegion = sprintf('%s %d', $region, $decada);

                if (!in_array($decadaRegion, $x)) {
                    $x []= $decadaRegion;
                }

                foreach ($datoCultivo as $cultivo => $data) {
                    if (!isset($haSembradas[$cultivo])) {
                        $haSembradas[$cultivo] = [
                            'name' => $cultivo,
                            'data' => [],
                        ];
                    }

                    $haSembradas[$cultivo]['data'] []= $data['haSembradas'];

                    if (!isset($haCosechadas[$cultivo])) {
                        $haCosechadas[$cultivo] = [
                            'name' => $cultivo,
                            'data' => [],
                        ];
                    }

                    $haCosechadas[$cultivo]['data'] []= $data['haCosechadas'];
                }
            }
        }

        $haSembradas  = array_values($haSembradas);
        $haCosechadas = array_values($haCosechadas);

        return new JsonResponse([
            'x'            => $x,
            'haSembradas'  => $haSembradas,
            'haCosechadas' => $haCosechadas,
        ]);
    }

    /**
     * @Route("/region/{id}")
     */
    public function region($id)
    {
        $doctrine = $this->getDoctrine();

        $region = $doctrine->getRepository(DEspacio::class)->findRegionById($id);

        $decadas = $doctrine->getRepository(DTiempo::class)->findAllDecadas();

        $provincias = $doctrine->getRepository(DEspacio::class)->findAllProvinciasByRegion($region);

        $cultivos = $doctrine->getRepository(DCultivo::class)->findAll();

        $datos = [];

        foreach ($decadas as $decada) {
            $decada = $decada['decada'];
            $datos[$decada] = [];

            foreach ($provincias as $provincia) {
                $provincia = $provincia['nombre'];
                $datos[$decada][$provincia] = [];

                foreach ($cultivos as $cultivo) {
                    $cultivo = $cultivo['nombre'];
                    $datos[$decada][$provincia][$cultivo] = [
                        'haSembradas'  => 0,
                        'haCosechadas' => 0,
                    ];
                }
            }
        }

        $medidas = $this->getDoctrine()->getRepository(HCosecha::class)->region($region);

        foreach ($medidas as $medida) {
            $datos[$medida['decada']][$medida['provincia']][$medida['cultivo']]['haSembradas']  = (int) $medida['haSembradas'];
            $datos[$medida['decada']][$medida['provincia']][$medida['cultivo']]['haCosechadas'] = (int) $medida['haCosechadas'];
        }

        $x = [];

        $haSembradas  = [];
        $haCosechadas = [];

        foreach ($datos as $decada => $dato) {
            foreach ($dato as $provincia => $datoCultivo) {
                $decadaProvincia = sprintf('%s %d', $provincia, $decada);

                if (!in_array($decadaProvincia, $x)) {
                    $x []= $decadaProvincia;
                }

                foreach ($datoCultivo as $cultivo => $data) {
                    if (!isset($haSembradas[$cultivo])) {
                        $haSembradas[$cultivo] = [
                            'name' => $cultivo,
                            'data' => [],
                        ];
                    }

                    $haSembradas[$cultivo]['data'] []= $data['haSembradas'];

                    if (!isset($haCosechadas[$cultivo])) {
                        $haCosechadas[$cultivo] = [
                            'name' => $cultivo,
                            'data' => [],
                        ];
                    }

                    $haCosechadas[$cultivo]['data'] []= $data['haCosechadas'];
                }
            }
        }

        $haSembradas  = array_values($haSembradas);
        $haCosechadas = array_values($haCosechadas);

        return new JsonResponse([
            'x'            => $x,
            'haSembradas'  => $haSembradas,
            'haCosechadas' => $haCosechadas,
        ]);
    }

    /**
     *
     */
    protected function provincia(Provincia $provincia)
    {
    }

    /**
     *
     */
    protected function cultivo(Cultivo $cultivo)
    {
    }

    /**
     *
     */
    protected function cultivoRegion(Cultivo $cultivo, DRegion $region)
    {
    }

    /**
     *
     */
    protected function cultivoProvincia(Cultivo $cultivo, Provincia $provincia)
    {
    }

    /**
     *
     */
    protected function decada(Decada $decada)
    {
    }

    /**
     *
     */
    protected function decadaRegion(Decada $decada, DRegion $region)
    {
    }

    /**
     *
     */
    protected function decadaProvincia(Decada $decada, Provincia $provincia)
    {
    }

    /**
     *
     */
    protected function decadaCultivo(Decada $decada, Cultivo $cultivo)
    {
    }

    /**
     *
     */
    protected function decadaCultivoRegion(Decada $decada, Cultivo $cultivo, DRegion $region)
    {
    }

    /**
     *
     */
    protected function decadaCultivoProvincia(Decada $decada, Cultivo $cultivo, Provincia $provincia)
    {
    }
}
