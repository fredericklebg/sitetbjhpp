<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EnergieController extends AbstractController
{
    /**
     * @Route("/energie", name="energie")
     */
    public function index()
    {
        if($this->getUser() != null) {
            $rand = rand(0, 10);
            if ($rand <= 5) {
                return $this->render('energie/index.html.twig', [
                    'controller_name' => 'EnergieController',
                ]);
            }
            return $this->render('energie/igni.html.twig', [
                'controller_name' => 'EnergieController',
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    /**
     * @Route("/success-energie", name="energie_success")
     */
    public function after(ManagerRegistry $manager){
        if($this->getUser() != null) {
            $bonusCouronnes = 10;

            /** @var User $user */
            $user = $this->getUser();

            $user->setCouronnes($user->getCouronnes() + $bonusCouronnes);

            $this->addFlash("success", "Tu as gagné 10 couronnes, bravo tu vas pouvoir t'acheter......rien");
            $manager->getManager()->persist($user);
            $manager->getManager()->flush();
        }
           return $this->redirectToRoute('tb');

    }
}
