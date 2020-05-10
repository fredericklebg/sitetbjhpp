<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MarcheController extends AbstractController
{
    /**
     * @Route("/marche", name="marche")
     */
    public function index()
    {
        return $this->render('marche/marche.html.twig', [
            'controller_name' => 'MarcheController',
        ]);
    }
}
