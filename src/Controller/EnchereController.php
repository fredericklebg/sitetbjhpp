<?php

namespace App\Controller;

use App\Entity\Enchere;
use App\Entity\HistoriqueEncheres;
use App\Entity\Produit;
use App\Entity\User;
use App\Form\EnchereType;
use App\Form\HistoriqueEncheresType;
use App\Repository\EnchereRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EnchereController extends AbstractController
{
    //TODO     Je m'excuse par avance de ne pas avoir pu implémenter la fonctionnalité la plus importante du site

    /**
     * @Route("/encheres", name="encheres")
     */
    public function index(EnchereRepository $repo)
    {
        $encheres = $repo->findAll();
        return $this->render('enchere/index.html.twig', [
            'controller_name' => 'EnchereController',
            'encheres' => $encheres,
        ]);
    }

    /**
     * @Route("/encheres/new", name="enchere_create")
     * @Route("/encheres/{id}/edit", name="enchere_edit")
     */
    public function form(Enchere $enchere = null, Request $request, ManagerRegistry $manager){
        if(!$enchere){
            $enchere = new Enchere();
        }

        $form = $this->createForm(EnchereType::class, $enchere);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!$enchere->getId()) {
                $enchere->setDateDebut(new \DateTime());
            }
            $manager->getManager()->persist($enchere);
            $manager->getManager()->flush();
            return $this->redirectToRoute('enchere_show', ['id' => $enchere->getId()
            ]);
        }

        return $this->render('enchere/create.html.twig', [
            'editMode' => $enchere->getId() != null,
            'formEnchere' => $form->createView(),
        ]);

    }

    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render('enchere/home.html.twig',[
            ]
            );
    }


    /**
     * @param EnchereRepository $repo
     * @param $id
     * @return Response
     * @Route("/encheres/{id}", name="enchere_show")
     * @throws Exception
     */
    public function show(EnchereRepository $repo, $id, Request $request, ManagerRegistry $manager){
        $enchere = $repo->find($id);

        $offre = new HistoriqueEncheres();




            $form = $this->createForm(HistoriqueEncheresType::class, $offre);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $offre->setDateEnchere(new \DateTime());
                $offre->setEnchere($enchere);
                $offre->setUser($this->getUser());

                $this->addFlash('success','Enchère réussie');

                $manager->getManager()->persist($offre);
                $manager->getManager()->flush();

                //return $this->redirectToRoute('enchere_success');
            }

            return $this->render('enchere/show.html.twig', [
                'enchere' => $enchere,
                'formOffre' => $form->createView()

            ]);

    }

    /**
     * @Route("/encheres/success", name="enchere_success")
     */
    public function success(){

        return $this->render('enchere/success.html.twig');
    }



}
