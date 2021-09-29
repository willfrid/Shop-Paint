<?php

namespace App\Controller;

use App\Entity\Blogpost;
use App\Entity\Commentaire;
use App\Entity\Peinture;
use App\Form\CommentaireFormType;
use App\Repository\PeintureRepository;
use App\Service\CommentaireService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeinturesController extends AbstractController
{
    /**
     * @Route("/peinture", name="realisation")
     */
    public function index(PeintureRepository $peintureRepository,PaginatorInterface $paginator,Request $request): Response
    {
        $data = $peintureRepository->findBy([],['id'=>'DESC']);
        $peintures = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),6
        );
        return $this->render('peintures/peinture.html.twig', [
            'peintures' => $peintures,
        ]);
    }
    /**
     * @Route("/peinture/{slug}", name="realisation_details")
     */
    public function detailPeinture(Peinture $peinture,Request $request,CommentaireService $commentaireService):Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireFormType::class,$commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $commentaire = $form->getData();
            $commentaireService->persistCommentaire($commentaire,null,$peinture);

            return $this->redirectToRoute('actualite_detail',['slug'=>$peinture->getSlug()]);
        }
        return $this->render('peintures/detailPeinture.html.twig', [
            'peinture' => $peinture,
            'form'     =>$form->createView(),
        ]);
    }
}
