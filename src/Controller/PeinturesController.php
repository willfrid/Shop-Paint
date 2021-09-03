<?php

namespace App\Controller;

use App\Repository\PeintureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeinturesController extends AbstractController
{
    /**
     * @Route("/peinture", name="app_peinture")
     */
    public function index(PeintureRepository $peintureRepository): Response
    {
        return $this->render('peintures/index.html.twig', [
            'peintures' => $peintureRepository->findAll()
        ]);
    }
}
