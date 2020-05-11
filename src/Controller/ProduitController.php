<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
//    /**
//     * @Route("/produit", name="produit")
//     */
//    public function index()
//    {
//        return $this->render('produit/index.html.twig', [
//            'controller_name' => 'ProduitController',
//        ]);
//    }

    /**
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/create-produit",name="produit-create")
     */
    public function create(Request $request, ManagerRegistry $managerRegistry){
        $produit = new Produit();

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $managerRegistry->getManager()->persist($produit);

            $target_dir = "uploads/produits/";
            $file = $_FILES['image']['name'];
            $path = pathinfo($file);
            $filename = md5(uniqid());
            $ext = $path['extension'];
            $temp_name = $_FILES['image']['tmp_name'];
            $path_filename_ext = $target_dir.$filename.".".$ext;
            move_uploaded_file($temp_name,$path_filename_ext);
            $produit->setImage($target_dir.$filename.".".$ext);

            $managerRegistry->getManager()->flush();

            return $this->redirectToRoute('tb');
        }

        return $this->render('produit/create.html.twig',[
            'formProduit' => $form->createView()
        ]);
    }

}
