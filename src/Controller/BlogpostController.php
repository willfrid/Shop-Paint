<?php

namespace App\Controller;

use App\Repository\BlogpostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogpostController extends AbstractController
{
    /**
     * @Route("/actualite", name="actualite")
     */
    public function actualite(BlogpostRepository $blogpostRepository,PaginatorInterface $paginator,Request $request): Response
    {
        $data = $blogpostRepository->findAll();
        $blogposts= $paginator->paginate(
            $data,$request->query->getInt('page',1),6
        );
        return $this->render('blogpost/actualite.html.twig', [
            'blogposts' =>$blogposts,
        ]);
    }
}
