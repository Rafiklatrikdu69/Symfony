<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('commentaire')]
class CommentaireController extends AbstractController
{
   

    // #[Route('/new', name: 'app_commentaire_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $commentaire = new Commentaire();
    //     $form = $this->createForm(CommentaireType::class, $commentaire);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($commentaire);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('commentaire/new.html.twig', [
    //         'commentaire' => $commentaire,
    //         'form' => $form,
    //     ]);
    // }

     #[Route('/{id}', name: 'app_commentaire_show', methods: ['GET','POST'])]
     public function show(Request $request,Article $article,CommentaireRepository $articleRepository,$id, EntityManagerInterface $entityManager): Response
     {
        $commentaire = new Commentaire();
        $form= $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setArticle($article);
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }
         return $this->render('commentaire/show.html.twig', [
             'article' => $article,
             'form_comm'=>$form->createView()
         ]);
     }

    // #[Route('/{id}/edit', name: 'app_commentaire_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(CommentaireType::class, $commentaire);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('commentaire/edit.html.twig', [
    //         'commentaire' => $commentaire,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_commentaire_delete', methods: ['POST'])]
    // public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($commentaire);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
    // }
}
