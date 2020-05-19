<?php

namespace App\Controller;

use App\Entity\Marais;
use App\Form\MaraisType;
use App\Repository\MaraisRepository;
use App\Repository\MarcheRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MaraisController extends AbstractController
{
    /**
     * @Route("/marais", name="marais")
     */
    public function index(MaraisRepository $repository)
    {
        $marais = $repository->findAll();

        return $this->render('marais/yrden.html.twig', [
            'controller_name' => 'MaraisController',
            'maraiss' => $marais,
        ]);
    }

    /**
     * @Route("/marais/{id}", name="marais_show")
     */
    public function show(MaraisRepository $repository , MarcheRepository $repository2 ,$id){
        $marais = $repository->find($id);
        $marches = $repository2->findBy(['marais' => $id]);
        return $this->render('marais/show.html.twig', [
            'marais' => $marais,
            'marches' => $marches
        ]);
    }


    /**
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/create-marais",name="marais_create")
     */
    public function create(Request $request, ManagerRegistry $managerRegistry){
        $marais = new Marais();

        $form = $this->createForm(MaraisType::class, $marais);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $managerRegistry->getManager()->persist($marais);
            $managerRegistry->getManager()->flush();
            return $this->redirectToRoute('marais');
        }

        return $this->render('marais/create.html.twig',[
            'formMarais' => $form->createView()
        ]);
    }
}
