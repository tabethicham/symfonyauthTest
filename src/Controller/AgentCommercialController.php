<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Devis;
use App\Entity\LignesDevis;
use App\Form\ClientType;
use App\Form\DevisType;
use App\Form\LignesDevisType;
use App\Repository\ClientRepository;
use App\Repository\DevisRepository;
use App\Repository\LignesDevisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\Exception\InvalidFindByCall;

use Shuchkin\SimpleXLSX;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\FormInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use \Knp\Snappy\Pdf;

class AgentCommercialController extends AbstractController
{
    private function getErrorsMessages(FormInterface $formClient):array{
        $errors=array();
        foreach($formClient->all() as $child){
            $temp=array();
            if(!$child->isValid()){
                foreach($child->getErrors() as $error){
                    array_push($temp, $error->getMessage());
                }
                //$errors[$child->getName()]=$this->getErrorsMessages($child);
                $errors[$child->getName()]=$temp;
            }
            
           
        }
        return $errors;
    }
   
    /**
     * @Route("/devis/pdf/{id}", name="pdf_devis", methods={"GET"})
     */
    public function pdfDevis(Devis $devis, Pdf $knpSnappyPdf):PdfResponse
    { 
            //$pageUrl = $this->generateUrl('home', array(), true); // use absolute path!

                $htmll = $this->renderView('agent_commercial/pdf.html.twig',
                 array('controller_name' => 'Consultation de CV',
                        'devis'=>$devis,
                 )
            );
                /*$options = [
                'margin-top' => 2,
                'margin-bottom' => 2,
                'margin-left' => 0,
                'margin-right' => 0,
            ];
    
        
            $knpSnappyPdf->setOptions($options);*/
            
           $a='Devis_'.$devis->getRefDevis().'.pdf';
           $a= str_replace('/','_',$a);
            return new PdfResponse(
                $knpSnappyPdf->getOutputFromHtml($htmll),$a
               
            );
    }
 
    /**
    * @Route("/agent/commercial/new", name="agentC_devis_new", methods={"GET", "POST","PUT"})
    */
    public function new(Session $session,DevisRepository $devisRepository,LignesDevisRepository $lignesDevisRepository,ClientRepository $clientRepository,Request $request, EntityManagerInterface $entityManager): Response
    { 
        //debut remlissage sequence
        $sequence=$devisRepository->getLastId()+1;
        $sequence2=$devisRepository->getLastIdByLastYear();
        $annee= (new \DateTime('now'))->format('Y');
        $sequence3=$sequence-$sequence2;
        $ref=$annee."/".$sequence3;
        // remlissage sequence

        $devi = new Devis();
        $devi->setDateDevis(new \DateTime('now'));
        $devi->setRefDevis($ref);
        //dd($devi);
       // $devi->setModalitesPaiementDevis("11");
       // $devi->setDelaiDevis("11");
        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);
        

        $lignesDevi = new LignesDevis();
        $formlignes = $this->createForm(LignesDevisType::class, $lignesDevi);
        $formlignes->handleRequest($request);

        $client = new Client();
        $formClient = $this->createForm(ClientType::class, $client);
        $formClient->handleRequest($request);

        //devis
        if($request->isXmlHttpRequest()){
            if ($form->isSubmitted() && $form->isValid()) {
                //$request->query->get('id');
                //$devi->setClient($clientRepository->find(  intval(           (explode(" ",$request->request->get('devis')['clientt'] ))[0] ,10)   ));
                //$devi->setClient($clientRepository->find($request->request->get('devis')['iid'] ));
               $temp=$clientRepository->findByRefClient($request->request->get('devis')['clientt'] )[0]->getId();
                $devi->setClient($clientRepository->find(    $temp       ));
               // $devi->setClient(($clientRepository->findByRefClient($request->request->get('devis')['clientt'] )[0])->getId() );

                $entityManager->persist($devi);
                $entityManager->flush();
                $session->set('foo', $devi);
            
               //$a =  $this->get('serializer')->serialize($devi->getId(), 'json');
                return new JsonResponse(['ref'=>$devi->getId()]);//,'ddd'=>$devi->getLignedevis()->getId()
                // return $this->redirectToRoute('devis_index', [], Response::HTTP_SEE_OTHER);
            }
            else
                if($form->isSubmitted() && !$form->isValid()){
                    $errors=$this->getErrorsMessages($form);
                    return new JsonResponse(['errors'=>$errors]);
                }
        }
        //Lignes devis  dd($lignesDevi);
        if($request->isXmlHttpRequest()){
            if ($formlignes->isSubmitted() && $formlignes->isValid()) {
                $lignesDevi->setDevis($devisRepository->find($session->get('foo')->getId()));// on va utilisr la session 
                $entityManager->persist($lignesDevi);
                $entityManager->flush();
                $a=$lignesDevisRepository->findBy( ['devis'=>$lignesDevi->getDevis()] );
                return $this->json($a,200,[],['groups'=>'lignesDevis:read']);//lignesDevis
               
            }
            /*else
                if(!$formlignes->isValid()){
                    $errors=$this->getErrorsMessages($formlignes);
                    return new JsonResponse(['errors'=>$errors]);
                }*/
        }
         //add client
         if($request->isXmlHttpRequest()){
            if($formClient->isSubmitted() && $formClient->isValid()) {
                //$lignesDevi->setDevis($devisRepository->find($session->get('foo')->getId()));// on va utilisr la session 
                $entityManager->persist($client);
                $entityManager->flush();
                
               //return $this->json($a,200,[],['groups'=>'lignesDevis:read']);
                return new JsonResponse([]);
            }
            else
                if($formClient->isSubmitted() && !$formClient->isValid()){
                    $errors=$this->getErrorsMessages($formClient);
                    return new JsonResponse(['errors'=>$errors]);
                }
        }
        return $this->renderForm('agent_commercial/index.html.twig', [
            'devi' => $devi,
            'form' => $form,
            'lignes_devi' => $lignesDevi,
            'formlignes' => $formlignes,
            'formClient'=>$formClient,
        ]);
    }//////////////

     /**
    * @Route("/agent/commercial/{id}/edit", name="agentC_devis_edit", methods={"GET", "POST","PUT"})
    */
    public function editDeviss(Session $session,Devis $devi,DevisRepository $devisRepository,LignesDevisRepository $lignesDevisRepository,ClientRepository $clientRepository,Request $request, EntityManagerInterface $entityManager): Response
    { 
        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);
        

        $lignesDevi = new LignesDevis();
        $formlignes = $this->createForm(LignesDevisType::class, $lignesDevi);
        $formlignes->handleRequest($request);

        $client = new Client();
        $formClient = $this->createForm(ClientType::class, $client);
        $formClient->handleRequest($request);

        //devis
        if($request->isXmlHttpRequest()){
            if ($form->isSubmitted() && $form->isValid()) {
                $temp=$clientRepository->findByRefClient($request->request->get('devis')['clientt'] )[0]->getId();
                $devi->setClient($clientRepository->find(    $temp       ));
                $entityManager->flush();
                $session->set('foo', $devi);

                return new JsonResponse(['ref'=>$devi->getId()]);
            }
            else
                if($form->isSubmitted() && !$form->isValid()){
                    $errors=$this->getErrorsMessages($form);
                    return new JsonResponse(['errors'=>$errors]);
                }
        }
        //Lignes devis  dd($lignesDevi);
        if($request->isXmlHttpRequest()){
            if ($formlignes->isSubmitted() && $formlignes->isValid()) {
                $lignesDevi->setDevis($devisRepository->find($session->get('foo')->getId()));// on va utilisr la session 
                $entityManager->persist($lignesDevi);
                $entityManager->flush();
                $a=$lignesDevisRepository->findBy( ['devis'=>$lignesDevi->getDevis()] );
                return $this->json($a,200,[],['groups'=>'lignesDevis:read']);//lignesDevis
               
            }
            /*else
                if(!$formlignes->isValid()){
                    $errors=$this->getErrorsMessages($formlignes);
                    return new JsonResponse(['errors'=>$errors]);
                }*/
        }
         //add client
         if($request->isXmlHttpRequest()){
            if($formClient->isSubmitted() && $formClient->isValid()) {
                //$lignesDevi->setDevis($devisRepository->find($session->get('foo')->getId()));// on va utilisr la session 
                $entityManager->persist($client);
                $entityManager->flush();
                
               //return $this->json($a,200,[],['groups'=>'lignesDevis:read']);
                return new JsonResponse([]);
            }
            else
                if($formClient->isSubmitted() && !$formClient->isValid()){
                    $errors=$this->getErrorsMessages($formClient);
                    return new JsonResponse(['errors'=>$errors]);
                }
        }
        return $this->renderForm('agent_commercial/indexUpdate.html.twig', [
            'devi' => $devi,
            'form' => $form,
            'lignes_devi' => $lignesDevi,
            'formlignes' => $formlignes,
            'formClient'=>$formClient,
        ]);
    }//////////////



    /**
    * @Route("/agent/lignesdevis/new", name="agent_lignesdevis", methods={"POST","PUT"})
    */
    public function newLinesDevis(Session $session,DevisRepository $devisRepository,LignesDevisRepository $lignesDevisRepository,ClientRepository $clientRepository,Request $request, EntityManagerInterface $entityManager): Response
    { 
        
        $lignesDevi = new LignesDevis();
        $formlignes = $this->createForm(LignesDevisType::class, $lignesDevi);
        $formlignes->handleRequest($request);

        if($request->isXmlHttpRequest()){
            if ($formlignes->isSubmitted() && $formlignes->isValid()) {
                $lignesDevi->setDevis($devisRepository->find($session->get('foo')->getId()));// on va utilisr la session 
                $entityManager->persist($lignesDevi);
                $entityManager->flush();
                $a=$lignesDevisRepository->findBy( ['devis'=>$lignesDevi->getDevis()] );
                return $this->json($a,200,[],['groups'=>'lignesDevis:read']);//lignesDevis
               
            }
            else
                if(!$formlignes->isValid()){
                    $errors=$this->getErrorsMessages($formlignes);
                    return new JsonResponse(['errors'=>$errors]);
                }
        }
         //add client
        
    return new jsonResponse([]);
    }
    /**
    * @Route("/agent/cliendevis/new", name="agent_client_devis", methods={"POST","PUT"})
    */
    public function newClientDevis(Session $session,DevisRepository $devisRepository,LignesDevisRepository $lignesDevisRepository,ClientRepository $clientRepository,Request $request, EntityManagerInterface $entityManager): Response
    { 
        
        $client = new Client();
        $formClient = $this->createForm(ClientType::class, $client);
        $formClient->handleRequest($request);
        //add client
        if($request->isXmlHttpRequest()){
            if($formClient->isSubmitted() && $formClient->isValid()) {
                //$lignesDevi->setDevis($devisRepository->find($session->get('foo')->getId()));// on va utilisr la session 
                $entityManager->persist($client);
                $entityManager->flush();
                
               //return $this->json($a,200,[],['groups'=>'lignesDevis:read']);
                return new JsonResponse([]);
            }
            else
                if($formClient->isSubmitted() && !$formClient->isValid()){
                    $errors=$this->getErrorsMessages($formClient);
                    return new JsonResponse(['errors'=>$errors]);
                }
        }
        
         
        
    return new jsonResponse([]);
    }

 /**
    * @Route("/agent/devis/new", name="agent_devis", methods={ "POST","PUT"})
    */
    public function newDevis(Session $session,DevisRepository $devisRepository,LignesDevisRepository $lignesDevisRepository,ClientRepository $clientRepository,Request $request, EntityManagerInterface $entityManager): Response
    { 
        $devi = new Devis();
       // $devi->setDateDevis(new \DateTime('now'));
        //$devi->setRefDevis($ref);
        //dd($devi);
       // $devi->setModalitesPaiementDevis("11");
       // $devi->setDelaiDevis("11");
        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);
        //devis
        if($request->isXmlHttpRequest()){
            if ($form->isSubmitted() && $form->isValid()) {
               $temp=$clientRepository->findByRefClient($request->request->get('devis')['clientt'] )[0]->getId();
                $devi->setClient($clientRepository->find(    $temp       ));
                $entityManager->persist($devi);
                $entityManager->flush();
                $session->set('foo', $devi);

                return new JsonResponse(['ref'=>$devi->getId()]);//,'ddd'=>$devi->getLignedevis()->getId()
                // return $this->redirectToRoute('devis_index', [], Response::HTTP_SEE_OTHER);
            }
            else
                if($form->isSubmitted() && !$form->isValid()){
                    $errors=$this->getErrorsMessages($form);
                    return new JsonResponse(['errors'=>$errors]);
                }
        }
        
            
        
      
        return new JsonResponse([]);
    }
    /**
    * @Route("/agent/devis/{id}/edit", name="agent_devis_edit", methods={"POST","PUT"})
    */
    public function editDevis(Session $session,Devis $devis,Request $request,ClientRepository $clientRepository, DevisRepository $devisRepository, EntityManagerInterface $entityManager)
    {   
        $form1 = $this->createForm(DevisType::class, $devis);
        $form1->handleRequest($request);
        if($request->isXmlHttpRequest()){
            if ($form1->isSubmitted() && $form1->isValid()) {
                $temp=$clientRepository->findByRefClient($request->request->get('devis')['clientt'] )[0]->getId();
                $devis->setClient($clientRepository->find(    $temp       ));
                $entityManager->flush();
                //$session->set('fooo',$devis->getId());    
                // $z=$devisRepository->find($devis->getId());
                // $a =  $this->get('serializer')->serialize($z, 'json');
                return new jsonResponse([]);
                //return $this->redirectToRoute('devis_index', [], Response::HTTP_SEE_OTHER);
            }
            else
                if($form1->isSubmitted() && !$form1->isValid()){
                    $errorss=$this->getErrorsMessages($form1);
                    return new JsonResponse(['errors'=>$errorss]);
                }
        }
        return new JsonResponse([]);
    }    


        /**
         * @Route("/agent/commercial/{id}/edit", name="devis_editttt", methods={"GET", "POST","PUT"})
         */
        public function edit(Session $session,Request $request,ClientRepository $clientRepository, DevisRepository $devisRepository,Devis $devis, EntityManagerInterface $entityManager)
        {   $lignesDevi = new LignesDevis();
            $formlignes = $this->createForm(LignesDevisType::class, $lignesDevi);
            $formlignes->handleRequest($request);
    
            $client = new Client();
            $formClient = $this->createForm(ClientType::class, $client);
            $formClient->handleRequest($request);

            $form1 = $this->createForm(DevisType::class, $devis);
            $form1->handleRequest($request);
            if($request->isXmlHttpRequest()){
            
                if ($form1->isSubmitted() && $form1->isValid()) {
                    $temp=$clientRepository->findByRefClient($request->request->get('devis')['clientt'] )[0]->getId();
                    $devis->setClient($clientRepository->find(    $temp       ));
                    $entityManager->flush();
                    //$session->set('fooo',$devis->getId());    
                   // $z=$devisRepository->find($devis->getId());
                   // $a =  $this->get('serializer')->serialize($z, 'json');
                    return new jsonResponse(['ref'=>12]);

                    //return $this->redirectToRoute('devis_index', [], Response::HTTP_SEE_OTHER);
                }
                else
                    if(!$form1->isValid()){
                        $errorss=$this->getErrorsMessages($form1);
                        return new JsonResponse(['errors'=>$errorss]);
                    }
            }
            return $this->renderForm('agent_commercial/index.html.twig', [
                'devi' => $devis,
                'form' => $form1,
                'lignes_devi' => $lignesDevi,
                'formlignes' => $formlignes,
                'formClient'=>$formClient,
            ]);
            /*return $this->renderForm('devis/edit.html.twig', [
                'devi' => $devi,
                'form' => $form,
            ]);*/
        }





        
        /**
            * @Route("/agent/commercial", name="agenthhommercial")
          */
        public function pdfAcbtion(Pdf $knpSnappyPdf)
        { 
        //$pageUrl = $this->generateUrl('home', array(), true); // use absolute path!

                $htmll = $this->renderView('agent_commercial/showDevis.html.twig', array('controller_name' => 'Consultation de CV',)
            );
                $options = [
                'margin-top' => 2,
                'margin-bottom' => 2,
                'margin-left' => 0,
                'margin-right' => 0,
            ];
    
        
            $knpSnappyPdf->setOptions($options);
    
            return new PdfResponse(
                $knpSnappyPdf->getOutputFromHtml($htmll),
                'file7.pdf'
            );
        }
        
        /**
         * @Route("/devis/{id}/consulter", name="consulter_devis")
         */
        public function index(Devis $devis): Response
        {
            return $this->render('agent_commercial/consulterDevis.html.twig', [
                'controller_name' => 'Consulter Pdf',
                'devis'=>$devis,
            ]);
        }
        

        /**
        * @Route("/agent/commercial/showdevis", name="show_Devis")
        */
        public function showDevis(): Response
        {
            return $this->render('agent_commercial/showDevis.html.twig', [
                'controller_name' => 'AgentCommercialController',
            ]);
        }

        //////////////////////////////////////////////////////////////////////////////////////
    function remplissageRefDevis(DevisRepository $devisRepository){
        $sequence="ee"; // 
        $annee= (new \DateTime('now'))->format('Y');
        $ref=$annee."/".$sequence;

    //  $annee = $annee->format('Y');
        
    }
    
    //////////////////////////////////////////////////////


}










//dd($session->get('foo'));
       // $xlsx =  SimpleXLSX::parse('test.xlsx');
        //dd($xlsx->rows()[3][2]);

        