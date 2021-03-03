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
     * @param MarcheRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ProduitRepository $repository)
    {

        if($this->getUser() != null) {

            $produits = $repository->getAllIds();
            $ids = array();
            foreach($produits as $produit){
                array_push($ids, $produit['id']);
            }

            return $this->render('pack_opening/index.html.twig', [
                'controller_name' => 'PackOpeningController',
                'produits'=>$produits,
                'ids'=>$ids
            ]);
        } else{
            $this->redirectToRoute('app_login');
        }
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
//        $obj = new Stdclass();
////        $obj->message = 'cool';
//    echo json_encode($obj);
        $produits = $request->get('produit');
        if(isset($produits)) {

            foreach ($produits as $produit) {
                $produit = $produitRepository->findOneBy(['id' => $produit]);

//        echo "produit :" . $id . "\n marche : " . $marcheId;
//        exit();
                if ($this->getUser() == null) {
                    $this->addFlash("error", "Inscris-toi pour acheter sale arnaqueur");
                    return $this->redirectToRoute('pack_opening');
                }

                /** @var \App\Entity\User $user */
                $user = $this->getUser();

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
                $manager->getManager()->persist($user);
                $manager->getManager()->flush();
            }
        }
    return new Response();
    }
}