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
        return $this->render('energie/index.html.twig', [
            'controller_name' => 'EnergieController',
        ]);
    }
}
