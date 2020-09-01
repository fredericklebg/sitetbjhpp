<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AggroController extends AbstractController
{
    /**
     * @Route("/aggro", name="aggro")
     */
    public function aggro()
    {

        return $this->render('aggro/index.html.twig');
    }
}
