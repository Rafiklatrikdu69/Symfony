<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/home')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET', 'POST'])]
    public function index(Request $request,ArticleRepository $articleRepository, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        $commentaire = new Commentaire();
        $form_comm = $this->createForm(CommentaireType::class, $commentaire);
        $form_comm->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();
           
            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }
        if ($form_comm->isSubmitted() && $form_comm->isValid()) {
            $entityManager->persist($commentaire);
            $entityManager->flush();
       
            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'form' =>$form,
            'form_comm'=>$form_comm
        ]);
    }
 
     #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
     public function new(Request $request, EntityManagerInterface $entityManager): Response
     {
         $article = new Article();
         $form = $this->createForm(ArticleType::class, $article);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $entityManager->persist($article);
             $entityManager->flush();

             return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
         }

         return $this->renderForm('article/new.html.twig', [
             'article' => $article,
             'form' => $form,
         ]);
     }

     #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
     public function show(Article $article,CommentaireRepository $articleRepository,$id): Response
     {
         return $this->render('article/show.html.twig', [
             'article' => $article,
             'commentaire'=>$articleRepository->findByExampleField($id)
         ]);
     }

    // #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(ArticleType::class, $article);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('article/edit.html.twig', [
    //         'article' => $article,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    // public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($article);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    // }
}
