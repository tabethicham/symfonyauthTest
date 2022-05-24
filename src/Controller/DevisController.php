<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Entity\Client;
use App\Form\DevisType;
use App\Form\DevisEditType;
use App\Repository\DevisRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use \Knp\Snappy\Pdf;

/**
 * @Route("/devis")
 */
class DevisController extends AbstractController
{
    

    /**
     * @Route("/", name="devis_index", methods={"GET"})
     */
    public function index(DevisRepository $devisRepository): Response
    {/*
        $products = $repository->findBy(
    ['name' => 'Keyboard'],
    ['price' => 'ASC']
);

        */
         
        return $this->render('devis/index.html.twig', [
            'devis' => $devisRepository->findAll(),
            //'devis' => $devisRepository->findBy([],['id' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="devis_new", methods={"GET", "POST"})
     */
    public function new(ClientRepository $clientRepository,Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $devi = new Devis();
        $devi->setDateDevis(new \DateTime('now'));
        
        //dd($devi);
        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);
        $devi->setModalitesPaiementDevis("null");
        $devi->setDelaiDevis("null");



        if ($form->isSubmitted() && $form->isValid()) {
           // dd(intval(           (explode(" ",$request->request->get('devis')['clientt'] ))[0] ,10));
            //dd($request->request->get('devis')['clientt']);//->get('devis[clientt]'));
            $devi->setClient($clientRepository->find(1));
            $entityManager->persist($devi);
            $entityManager->flush();

            return $this->redirectToRoute('devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('devis/new.html.twig', [
            'devi' => $devi,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="devis_show", methods={"GET"})
     */
    public function show(Devis $devi): Response
    {
        return $this->render('devis/show.html.twig', [
            'devi' => $devi,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="devis_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Devis $devi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DevisEditType::class, $devi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->flush();

            return $this->redirectToRoute('devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('devis/edit.html.twig', [
            'devi' => $devi,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="devis_delete", methods={"POST"})
     */
    public function delete(Request $request, Devis $devi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$devi->getId(), $request->request->get('_token'))) {
            $entityManager->remove($devi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('devis_index', [], Response::HTTP_SEE_OTHER);
    }
}
