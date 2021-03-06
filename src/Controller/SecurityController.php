<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\ProduitRepository;
use App\Repository\UserProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ManagerRegistry $manager, UserPasswordEncoderInterface $encoder){
        if($this->getUser() != null){
            $this->addFlash("error", "Tu es déjà inscris ! Enflure");
            return $this->redirectToRoute('tb');
        }
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setCouronnes(50);

            $this->addFlash("success", "Tu es maintenant inscrist, vas faire un petit pack opening en t'attendant");
            $manager->getManager()->persist($user);
            $manager->getManager()->flush();
            return $this->redirectToRoute('app_login');
        }

        return $this->render("security/registration.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

//    private function array_push_assoc($array, $key, $value){
//        $array[$key] = $value;
//        return $array;
//    }

//    private function countProducts($products){
//        $inventory = [];
//        foreach ($products as $item){
//
//        }
//    }

    /**
     * @Route("/profil", name="user_profile")
     */
    public function userProfile(UserProduitRepository $userProduitRepository,ProduitRepository $produitRepository){

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $products = $userProduitRepository->findBy(['user'=>$user]);
//        $inventory = [];
//
//        foreach ($products as $item){
////            $this->array_push_assoc($inventory,$item->getProduit(),$item->getQuantity());
//            $inventory[$item->getProduit()] = $item->getQuantity();
//        }
        return $this->render('security/profil.html.twig',['inventory'=>$products]);
    }



}
