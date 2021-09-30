<?php

namespace App\Controller;

use App\Repository\BlogpostRepository;
use App\Repository\CategorieRepository;
use App\Repository\PeintureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    /**
     * @Route("/sitemap.xml", name="sitemap",defaults={"_format"="xml"})
     */
    public function index(Request $request,PeintureRepository $peintureRepository
        ,BlogpostRepository $blogpostRepository,CategorieRepository $categorieRepository): Response
    {
        $hostname = $request->getSchemeAndHttpHost();
         //on cree un tableau qui va stocké nos url

        $urls = [];

        $urls[] = ['loc'=>$this->generateUrl('home')];
        $urls[] = ['loc'=>$this->generateUrl('realisation')];
        $urls[] = ['loc'=>$this->generateUrl('actualité')];
        $urls[] = ['loc'=>$this->generateUrl('portfolio')];
        $urls[] = ['loc'=>$this->generateUrl('apropos')];
        $urls[] = ['loc'=>$this->generateUrl('contact')];

        foreach ($peintureRepository->findAll() as $peinture){

            $urls[] = [
                'loc' => $this->generateUrl('realisation_details',['slug'=>$peinture->getSlug()]),
                'lastmod' => $peinture->getCreatedAt()->format('Y-m-d')
            ];
        }
        foreach ($blogpostRepository->findAll() as $blogpost){

            $urls[] = [
                'loc' => $this->generateUrl('actualité_detail',['slug'=>$blogpost->getSlug()]),
                'lastmod' => $peinture->getCreatedAt()->format('Y-m-d')
            ];
        }
        foreach ($categorieRepository->findAll() as $categorie){

            $urls[] = [
                'loc' => $this->generateUrl('actualité_detail',['slug'=>$categorie->getSlug()]),

            ];
        }

        $response  = new Response(
            $this->renderView('sitemap/index.html.twig',[
                'urls'=>$urls,
                'hostname' =>$hostname,
                ]),
                200
        );
        $response->headers->set('Content-type','text/xml');

        return $response;

    }
}
