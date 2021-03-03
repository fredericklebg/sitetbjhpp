<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Entity\UserProduit;
use App\Repository\MarcheRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use http\Message;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Validator\Constraints\Json;

class  PackOpeningController extends AbstractController
{
    /**
     * @Route("/pack-opening", name="pack_opening")
     * @param ProduitRepository $repository
     * @return Response
     */
    public function index(ProduitRepository $repository): Response
    {

        if($this->getUser() != null) {
            //Fout dans le tableau ids les ids de TOUS les produits du site
            $produits = $repository->getAllIds();
            $ids = array();
            foreach($produits as $produit){
                array_push($ids, $produit['id']);
            }

            return $this->render('pack_opening/index.html.twig', [
                'controller_name' => 'PackOpeningController',
                'ids'=>$ids
            ]);
        }
        //Si pas connecté
        $this->addFlash("error", "Inscris-toi pour faire un pack opening bordel");
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/pack-opened", name="pack_opened")
     * @param ProduitRepository $produitRepository
     * @param UserProduitRepository $userProduitRepository
     * @param Request $request
     * @param ManagerRegistry $manager
     * @return Response
     */
    public function openBox(ProduitRepository $produitRepository, UserProduitRepository $userProduitRepository, Request $request, ManagerRegistry $manager){
        if ($this->getUser() == null) {
            $this->addFlash("error", "Inscris-toi pour faire un pack opening bordel");
            return $this->redirectToRoute('pack_opening');
        }

        /** @var User $user */
        $user = $this->getUser();
//
//        if($user->getCouronnes() < 200){
//            $this->addFlash("error", "Tu crois que le pack est gratuit clochard ???" .
//                " Eh ouai c trop jvais péter un cable");
//            return $this->redirectToRoute('pack_opening');
//        }
        $user->setCouronnes(5000);

        //Récupère les données d'ajax depuis index dans le Template de packopening
        $produits = $request->get('produit');
        $images = array();
        $imgNames = array();
        $obj = new Stdclass();
        if(isset($produits)) {

            foreach ($produits as $produit) {
                $produit = $produitRepository->findOneBy(['id' => $produit]);

                array_push($images,$produit->getImage());
                array_push($imgNames, $produit->getName());
//                array_push($images, $imageProduit);
//        echo "produit :" . $id . "\n marche : " . $marcheId;
//        exit();

                $userProduct = $userProduitRepository->findOneBy(['user' => $user, 'produit' => $produit]);

                if (isset($userProduct) == 0) {
                    $newProduct = new UserProduit();
                    $newProduct->setUser($user);
                    $newProduct->setProduit($produit);
                    $user->addproduit($newProduct, 1);
                } else {
                    $oldQuantity = $userProduitRepository->getProductsNumber($user, $produit);
                    $userProduct->setQuantity($oldQuantity + 1);
                }

            }
            $obj->images = $images;
            $obj->names = $imgNames;


        }

        echo json_encode($obj);
        $manager->getManager()->persist($user);
        $manager->getManager()->flush();
    return new Response();
    }
}