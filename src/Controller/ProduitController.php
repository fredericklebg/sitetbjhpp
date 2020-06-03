<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Form\ProduitType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @Route("/admin/edit-produit/{id}", name="produit_edit")
     * @Route("/admin/create-produit",name="produit_create")
     */
    public function create(Produit $produit = null, Request $request, ManagerRegistry $managerRegistry){
        if(! $produit) {
            $produit = new Produit();
        }

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            if($_FILES['image']['name'] != ""){
                $target_dir = "uploads/produits/";
                $file = $_FILES['image']['name'];
                $path = pathinfo($file);
                $filename = md5(uniqid());
                $ext = $path['extension'];
                $temp_name = $_FILES['image']['tmp_name'];
                $path_filename_ext = $target_dir . $filename . "." . $ext;
                move_uploaded_file($temp_name, $path_filename_ext);

                $produit->setImage($target_dir . $filename . "." . $ext);
            }
            $managerRegistry->getManager()->persist($produit);
            $managerRegistry->getManager()->flush();

            return $this->redirectToRoute('marche');

        }

        return $this->render('produit/create.html.twig',[
            'formProduit' => $form->createView(),
            'editMode' => $produit->getId() != null
        ]);
    }

    /**
     * @Route("/achat-produit/{name}", name="produit_achat")
     * @param User $user
     * @ParamConverter("produit", options={"mapping": {"produit_name" : "name"}})
     * @ParamConverter("marche", options={"mapping": {"marche_id": "id" }})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function buyProduct(User $user, Produit $produit, /*$quantity,*/ $marche_id){
        $user->achat($produit->getPrix()/*, $quantity*/);

        return $this->redirectToRoute('marche_show', [
            'id' => $produit->getId(),
            'marche_id' => $marche_id,
            'produit_name' => $produit->getName(),
            'user' => $user
        ]);
    }

}
