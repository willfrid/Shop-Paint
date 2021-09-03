<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogpostController extends AbstractController
{
    /**
     * @Route("/blogpost", name="blogpost")
     */
    public function index(): Response
    {
        return $this->render('blogpost/index.html.twig', [
            'controller_name' => 'BlogpostController',
        ]);
    }
}
