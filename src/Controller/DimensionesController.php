<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\DCultivo;
use App\Entity\DEspacio;
use App\Entity\DTiempo;

class DimensionesController extends AbstractController
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
}
