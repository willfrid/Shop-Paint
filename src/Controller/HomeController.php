<?php

namespace App\Controller;

use App\Repository\BlogpostRepository;
use App\Repository\PeintureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Home1Controller extends AbstractController
{
    /**
     * @Route("/home1", name="home1")
     */
    public function index(PeintureRepository $peintureRepository,BlogpostRepository $blogpostRepository): Response
    {
        return $this->render('home1/index.html.twig',[
            'peintures'=>$peintureRepository->lassTree(),
            'blogposts'=>$blogpostRepository->lassTree()
        ]);
    }
}
