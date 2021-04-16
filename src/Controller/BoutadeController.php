<?php

namespace App\Controller;

use App\Entity\Boutade;
use App\Form\BoutadeType;
use App\Repository\BoutadeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/boutade")
 */
class BoutadeController extends AbstractController
{
    /**
     * @Route("/", name="boutade_index", methods={"GET"})
     */
    public function index(BoutadeRepository $boutadeRepository): Response
    {
        return $this->render('boutade/index.html.twig', [
            'boutades' => $boutadeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="boutade_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $boutade = new Boutade();
        $form = $this->createForm(BoutadeType::class, $boutade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($boutade);
            $entityManager->flush();

            return $this->redirectToRoute('boutade_index');
        }

        return $this->render('boutade/new.html.twig', [
            'boutade' => $boutade,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="boutade_show", methods={"GET"})
     */
    public function show(Boutade $boutade): Response
    {
        return $this->render('boutade/show.html.twig', [
            'boutade' => $boutade,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="boutade_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Boutade $boutade): Response
    {
        $form = $this->createForm(BoutadeType::class, $boutade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('boutade_index');
        }

        return $this->render('boutade/edit.html.twig', [
            'boutade' => $boutade,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="boutade_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Boutade $boutade): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boutade->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($boutade);
            $entityManager->flush();
        }

        return $this->redirectToRoute('boutade_index');
    }

    /**
     * @Route("/random", name="boutade_get",methods={"GET","POST"})
     */
    public function getRandomBoutade(){

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if ($user->getBoutadeDate() == null || time() - $user->getBoutadeDate() > (24*3600) ){



        }
    }
}
