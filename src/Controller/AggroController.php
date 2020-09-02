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
        $randomPosition1 = rand(0,200);
        $randomPosition2 = rand(0,200);
        $randomPosition3 = rand(0,200);
        $randomPosition4 = rand(0,200);
        $randomPosition5 = rand(0,200);
        $randomPosition6 = rand(0,200);
        return $this->render('aggro/index.html.twig', [
            'decalmargin1' => $randomPosition1,
            'decalmargin2' => $randomPosition2,
            'decalmargin3' => $randomPosition3,
            'decalmargin4' => $randomPosition4,
            'decalmargin5' => $randomPosition5,
            'decalmargin6' => $randomPosition6,
        ]);
    }
}
