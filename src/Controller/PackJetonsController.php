<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Entity\PackJetons;
use App\Form\PackJetonsType;
use App\Repository\PackJetonsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PackJetonsController extends AbstractController
{
    /**
     * @Route("/packjetons", name="achat_pack_jetons")
     */
    public function achat(PackJetonsRepository $packJetonsRepository)
    {
        $pack = $packJetonsRepository->findAll();

        return $this->render('pack_jetons/achat.html..twig', [
            'controller_name' => 'PackJetonsController',
            'packsJetons' => $pack,
        ]);
    }

    /**
     * @Route("/create_pack",name="create_pack_jetons")
     * @Route("/pack_jetons/{id}/edit", name="edit_pack_jetons")
     */
    public function createPack(PackJetons $pack = null,Request $request, ManagerRegistry $manager){
        if(!$pack) {
            $pack = new PackJetons();
        }

        $form = $this->createForm(PackJetonsType::class, $pack);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->getManager()->persist($pack);
            $manager->getManager()->flush();
            return $this->redirectToRoute('achat_pack_jetons');
        }

        return $this->render('pack_jetons/createpack.html.twig',[
            'editMode' => $pack->getId() != null,
            'formPackJetons' => $form->createView(),

        ]);

    }
}
