<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeinturesController extends AbstractController
{
    /**
     * @Route("/peintures", name="peintures")
     */
    public function index(): Response
    {
        return $this->render('peintures/index.html.twig', [
            'controller_name' => 'PeinturesController',
        ]);
    }
}
