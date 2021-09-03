<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AproposController extends AbstractController
{
    /**
     * @Route("/apropos", name="apropos")
     */
    public function user(UserRepository $repository): Response
    {
        return $this->render('apropos/user.html.twig', [
            'peintre' =>$repository->getPeintre(),
        ]);
    }
}
