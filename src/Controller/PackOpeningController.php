<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class  PackOpeningController extends AbstractController
{
    /**
     * @Route("/pack-opening", name="pack_opening")
     */
    public function index()
    {
        if($this->getUser() != null) {
            return $this->render('pack_opening/index.html.twig', [
                'controller_name' => 'PackOpeningController',
            ]);
        } else{
            $this->redirectToRoute('app_login');
        }
    }

    /**
     * @Route("/pack-opened", name="pack_opened")
     */
    public function openBox(){

    }
}