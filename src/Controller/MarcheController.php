<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MarcheController extends AbstractController
{
    /**
     * @Route("/marche", name="marche")
     */
    public function index(ProduitRepository $repository)
    {
        $produits = $repository->findAll();
        return $this->render('marche/marche.html.twig', [
            'controller_name' => 'MarcheController',
            'produits' => $produits,
        ]);
    }
}
