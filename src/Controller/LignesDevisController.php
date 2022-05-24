<?php

namespace App\Controller;

use App\Entity\LignesDevis;
use App\Form\LignesDevisType;
use App\Repository\LignesDevisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lignes/devis")
 */
class LignesDevisController extends AbstractController
{
    /**
     * @Route("/", name="lignes_devis_index", methods={"GET"})
     */
    public function index(LignesDevisRepository $lignesDevisRepository): Response
    {
        return $this->render('lignes_devis/index.html.twig', [
            'lignes_devis' => $lignesDevisRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="lignes_devis_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,LignesDevisRepository $lignesDevisRepository): Response
    {
        $lignesDevi = new LignesDevis();
        $form = $this->createForm(LignesDevisType::class, $lignesDevi);
        $form->handleRequest($request);
        //dd($lignesDevi);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lignesDevi);
            $entityManager->flush();
           
           // return $this->redirectToRoute('lignes_devis_new', [], Response::HTTP_SEE_OTHER);
           return $this->renderForm('lignes_devis/new.html.twig', [
            'lignesDevis'=>$lignesDevisRepository->findBy( ['devis'=>$lignesDevi->getDevis()] ),//'lignesDevis'=>$lignesDevisRepository->findAll(),  
            'lignes_devi' => new LignesDevis(),
            'formlignes' => $this->createForm(LignesDevisType::class, (new LignesDevis())->setDevis($lignesDevi->getDevis())),
        ]);
        }
       // dd($lignesDevi);
        return $this->renderForm('lignes_devis/new.html.twig', [
            'lignes_devi' => $lignesDevi,
            'formlignes' => $form,
            'lignesDevis'=>$lignesDevisRepository->findBy( ['devis'=>$lignesDevi->getDevis()] ),//'lignesDevis'=>$lignesDevisRepository->findAll(),  
        ]);
        
    }

    /**
     * @Route("/{id}", name="lignes_devis_show", methods={"GET"})
     */
    public function show(LignesDevis $lignesDevi): Response
    {
        return $this->render('lignes_devis/show.html.twig', [
            'lignes_devi' => $lignesDevi,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lignes_devis_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, LignesDevis $lignesDevi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LignesDevisType::class, $lignesDevi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('lignes_devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lignes_devis/edit.html.twig', [
            'lignes_devi' => $lignesDevi,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="lignes_devis_delete", methods={"POST"})
     */
    public function delete(Request $request, LignesDevis $lignesDevi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lignesDevi->getId(), $request->request->get('_token'))) {
            $entityManager->remove($lignesDevi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lignes_devis_index', [], Response::HTTP_SEE_OTHER);
    }
}
