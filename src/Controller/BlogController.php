<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article = null, Request $request, ManagerRegistry $manager){

        if(!$article){
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }
            $manager->getManager()->persist($article);
            $manager->getManager()->flush();
            return $this->redirectToRoute('blog_show', ['id' => $article->getId()
            ]);
        }

        return $this->render('blog/create.html.twig', [
            'editMode' => $article->getId() != null,
            'formArticle' => $form->createView()
        ]);

    }

    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render('blog/home.html.twig',[
            'title' => 'Yo les giga BG',
            ]
            );
    }


    /**
     * @param ArticleRepository $repo
     * @param $id
     * @return Response
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(ArticleRepository $repo, $id){

        $article = $repo->find($id);
        return $this->render('blog/show.html.twig',[
            'article' => $article,

        ]);
    }


}
