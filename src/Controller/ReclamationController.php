<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReclamationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReclamationRepository;
use App\Entity\Reclamation;
use DateTime;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;




class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'app_reclamation')]
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
    
    #[Route('/reclamation/add', name: 'reclam_comment')]
    public function addReclamation(ManagerRegistry $doctrine , Request $req):Response{
        $em=$doctrine->getManager();
        $reclamation= new Reclamation();
        $form = $this->createForm(ReclamationType::class,$reclamation);
        $form->handleRequest($req);
        if($form->isSubmitted()&& $form->isValid()){
            $reclamation->setDate(new DateTime()); ///on prend le date systéme 

            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('reclam_comment');
        }
        return $this->renderForm('reclamation/add.html.twig', ['form'=>$form]);

    }
    #[Route('/reclamation/list', name: 'list_reclamation')]

    public function showAction() {

        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class);
        $reclamation = $reclamation->findAll();

        return $this->render(
            'reclamation/list.html.twig',
            array('reclamation' => $reclamation)
        );
    }
}
