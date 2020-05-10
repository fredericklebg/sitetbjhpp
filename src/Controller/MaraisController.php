<?php

namespace App\Controller;

use App\Entity\Marais;
use App\Form\MaraisType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MaraisController extends AbstractController
{
    /**
     * @Route("/marais", name="marais")
     */
    public function index()
    {
        return $this->render('marais/index.html.twig', [
            'controller_name' => 'MaraisController',
        ]);
    }

    /**
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/create-marais",name="marais_create")
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