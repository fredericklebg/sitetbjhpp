<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Entity\UserProduit;
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
     * @Route("/achat-produit/{id}/{marcheId}", name="produit_achat")
     * @param ProduitRepository $produitRepository
     * @return RedirectResponse
     */
    public function buyProduct(ProduitRepository $produitRepository /*$quantity,*/, ManagerRegistry $manager,int $id, int $marcheId){
        $produit = $produitRepository->findOneBy(['id' => $id]);

//        echo "produit :" . $id . "\n marche : " . $marcheId;
//        exit();
        if($this->getUser() == null){
            $this->addFlash("error", "Inscris-toi pour acheter sale arnaqueur");
            return $this->redirectToRoute('marche_show', ['id' => $marcheId]);
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $total_price = $produit->getPrix() /*$quantity*/;

        if($user->getCouronnes() - $total_price < 0){
            $this->addFlash("error", "Pas assez de cash sale clochard");
            return $this->redirectToRoute('marche_show', ['id' => $marcheId]);
        }
        $newProduct = new UserProduit();
        $newProduct->setUser($user);
        $newProduct->setProduit($produit);
        $user->setCouronnes($user->getCouronnes() - $total_price);
        $user->addproduit($newProduct,1);

        //TODO truc pour check cb il a d'item et ajouter le bon nombre

        $manager->getManager()->persist($user);
        $manager->getManager()->flush();

        //$user->achat($produit->getPrix()/*, $quantity*/);

        return $this->redirectToRoute('marche_show', [
            'id' => $marcheId,
        ]);
    }

}
