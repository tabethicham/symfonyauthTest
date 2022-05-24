<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;



/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client_index", methods={"GET"})
     */
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="client_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/new.html.twig', [
            'client' => $client,
            'formClient' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/edit.html.twig', [
            'client' => $client,
            'formClient' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="client_delete", methods={"POST"})
     */
    public function delete(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/jsoon/{id}", name="client_show1", methods={"GET"})
     */
    public function show1(Client $client,SerializerInterface $serializer)
    {  // dd(json_encode($client));
      //  return new JsonResponse( json_decode( $client));
     // $data = $serializer->serialize(array($client)[0], 'json');
      // $this->get('serializer')->serialize($client, 'json');
       // $data=array($client)[0];
       // dd($data['id']);
      $response = new JsonResponse((array)$client);
      $response->headers->set('Content-Type', 'application/json');

      return $response;
    }

    /**
     * @Route("/jsoon/em/{email}", name="client_showemm", methods={"GET"})
     */
    public function showemail(string $email,ClientRepository $clientRepository,SerializerInterface $serializer)
    {   
        // dd(json_encode($client));
        //  return new JsonResponse( json_decode( $client));
        // $data = $serializer->serialize(array($client)[0], 'json');
        // $this->get('serializer')->serialize($client, 'json');
        // $data=array($client)[0];
        // dd($data['id']);
        // dd($clientRepository->findByEmail("az"));


      //creation dune session pour ajouter l id et l email, refClient.... 
      //$data=$clientRepository->findByEmail($email);
      $data=$clientRepository->findByRefClient($email);
        for($i=0;$i<count($data);++$i){
            //$data[$i]=$data[$i]->getId().' '.$data[$i]->getEmailClient().' '.$data[$i]->getRefClient();
            $data[$i]=$data[$i]->getRefClient();
        }

      
      $response = new JsonResponse($data);
       
      $response->headers->set('Content-Type', 'application/json');

      return $response;
    }






}
