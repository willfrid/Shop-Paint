<?php

namespace App\Controller;

use App\Entity\Blogpost;
use App\Entity\Commentaire;
use App\Form\CommentaireFormType;
use App\Repository\BlogpostRepository;
use App\Repository\CommentaireRepository;
use App\Service\CommentaireService;
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
        $data = $blogpostRepository->findBy([],['id'=>'DESC']);
        $blogposts= $paginator->paginate(
            $data,$request->query->getInt('page',1),6
        );
        return $this->render('blogpost/actualite.html.twig', [
            'blogposts' =>$blogposts,
        ]);
    }

    /**
     * @Route("/actualite/{slug}", name="actualité_detail")
     */
    public function detailBlogpost(Blogpost $blogpost,Request $request,CommentaireService $commentaireService,CommentaireRepository $commentaireRepository): Response
    {
        $commentaires = $commentaireRepository->findCommentaire($blogpost);
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireFormType::class,$commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $commentaire = $form->getData();
            $commentaireService->persistCommentaire($commentaire,$blogpost,null);

            return $this->redirectToRoute('actualite_detail',['slug'=>$blogpost->getSlug()]);
        }
        return $this->render('blogpost/detailBlogpost.html.twig', [
            'blogpost'      =>$blogpost,
            'form'          =>$form->createView(),
            'commentaires'  =>$commentaires,
        ]);
    }
}
