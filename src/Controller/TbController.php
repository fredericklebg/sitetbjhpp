<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TbController extends AbstractController
{
    /**
     * @Route("/", name="tb")
     */
    public function index()
    {
        return $this->render('tb/index.html.twig', [
            'controller_name' => 'TbController',
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(){

        return $this->render('tb/about.html.twig');
    }

    /**
     * @Route("/brolstar", name="brolstar")
     */
    public function brolstar(){
        return $this->render('tb/brolstar.html.twig');
    }
}
