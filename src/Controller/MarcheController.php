<?php

namespace App\Controller;

use App\Entity\Marche;
use App\Form\MarcheType;
use App\Repository\MarcheRepository;
use App\Repository\ProduitRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MarcheController extends AbstractController
{
    /**
     * @Route("/marche", name="marche")
     */
    public function index(Request $request, ManagerRegistry $manager, MarcheRepository $repository, ProduitRepository $repository2)
    {
        $marches = $repository->findAll();


        return $this->render('marche/marche.html.twig', [
            'controller_name' => 'MarcheController',
            'marches' => $marches,
        ]);
    }

    /**
     * @Route("/marche/{id}", name="marche_show")
     */
    public function show(MarcheRepository $repository, $id){
        $marche = $repository->findOneBy(['id' => $id]);

        return $this->render('marche/show.html.twig', [
            'marche' => $marche,
            'produits' => $marche->getProduit()
        ]);
    }

    /**
     * @param Request $request
     * @param ManagerRegistry $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/create-marche", name="marche_create")
     */
    public function createMarche(Request $request, ManagerRegistry $manager){
        $marche = new Marche();

        $form = $this->createForm(MarcheType::class, $marche);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->getManager()->persist($marche);
            $manager->getManager()->flush();
            $this->addFlash('success', 'bg le san t\'a créé le marché');
            return $this->redirectToRoute('marche');

        }

        return $this->render('marche/create.html.twig', [
            'formMarche' => $form->createView()
        ]);

    }
}
