<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
     * @param ProduitRepository $produitRepository
     * @return RedirectResponse
     */
    public function buyProduct(ProduitRepository $produitRepository /*$quantity,*/){
        $produit = $produitRepository->findOneBy(['id' => '9']);

        if($this->getUser() == null){
            $this->addFlash("error", "Inscris-toi pour acheter sale arnaqueur");
            return $this->redirectToRoute('marche_show', ['id' => 1]);
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $total_price = $produit->getPrix() /*$quantity*/;
        if($user->getCouronnes() - $total_price < 0){
            $this->addFlash("error", "Pas assez de cash sale clochard");
        }
        $user->setCouronnes(100);
        $user->setCouronnes($user->getCouronnes() - $total_price);


        //$user->achat($produit->getPrix()/*, $quantity*/);

        return $this->redirectToRoute('marche_show', [
            'id' => 1,
        ]);
    }

}
