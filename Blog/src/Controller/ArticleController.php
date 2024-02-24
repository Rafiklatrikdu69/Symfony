<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\ArticleType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
            echo "formulaire envoyer";
            $entityManager->persist($article);
            var_dump($article);
            $entityManager->flush();
           
            // return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }
      
     
        if($request->query->get('cat')!=null){

            $categorie = $request->get('cat');
            if (empty($categorie)) {
                return $this->redirectToRoute('app_article_index');
            }
    
            $articles = (new ArrayCollection($articleRepository->findAll()));
          //  var_dump($articles);
            //On filtre les articles qui ont la bonne catégorie
            //ON aurait pu le faire en SQL/DQL via le repository mais ça vous montre une petite fonctionnalité sympa
            $articles = $articles->filter(
                function (Article $item) use ($categorie) {
                    return in_array($categorie,
                        array_values(
                            $item->getCategories()->map(
                                function (Categorie $cat) {
                                    return $cat->getNom();
                                }
                            )->getValues())
                    );
                }
            )->getValues();
           // var_dump($articles);
            return $this->renderForm('article/index.html.twig', [
                'article_filtre' => $articles,
                'articles' => '',
            'form' =>$form,
            'form_comm'=>$form_comm
                
            ]);

        }
        return $this->renderForm('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'form' =>$form,
            'form_comm'=>$form_comm
        ]);
    }
 
    #[Route('/new/{id}', name: 'app_article_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, $id): Response
{

    $article = $entityManager->getRepository(Article::class)->find($id);

    $commentaire = new Commentaire();
    $commentaire->setPseudo("pseudo");
    $commentaire->setDescription("rafik");
    $commentaire->setArticle($article);
    $entityManager->persist($commentaire);
    $entityManager->flush();

   

  
    return $this->renderForm('article/new.html.twig', [
       
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
