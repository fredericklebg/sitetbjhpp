<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Form\ContratType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contrat")
 */
class ContratController extends AbstractController
{
    /**
     * @Route("/", name="contrat_index")
     */
    public function index(){
        return $this->render('contrat/index.html.twig', [
            'controller_name' => 'ContratController',
        ]);
    }

    /**
     * @Route("/new", name="contrat_new", methods={"GET","POST"})
     */
    public function new(Request $request){
        $contrat = new Contrat();
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success','bg le san t\'a le contrat');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contrat);
            $entityManager->flush();

            return $this->redirectToRoute('contrat_index');
        }

        return $this->render('contrat/new.html.twig',[
            'contrat' => $contrat,
            'form' => $form->createView(),
            ]);
    }

    /**
     * @Route("/{id}/edit", name="contrat_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Contrat $contrat
     * @return Response
     */
    public function edit(Request $request, Contrat $contrat): Response
    {
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contrat_index');
        }

        return $this->render('contrat/edit.html.twig', [
            'contrat' => $contrat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contrat_delete", methods={"DELETE"})
     * @param Request $request
     * @param Contrat $contrat
     * @return Response
     */
    public function delete(Request $request, Contrat $contrat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contrat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contrat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contrat_index');
    }
}
