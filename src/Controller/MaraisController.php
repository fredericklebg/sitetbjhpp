<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
