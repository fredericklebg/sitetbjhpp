<?php

namespace App\Controller;

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
}
