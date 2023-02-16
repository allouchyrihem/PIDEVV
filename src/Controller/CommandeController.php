<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use app\Form\CommandeFormType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CommandeRepository;
use App\Entity\Commande;
class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commandeapp')]
    public function index(CommandeRepository $commandeRepository, ManagerRegistry $em): Response
    {
        $commandes = $em->getRepository(Commande::class)->findAll();
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
            'commandes'=>$commandes
        ]);
    }
    #[Route('/commande/{id}', name: 'app_commande_id')]
    public function commandeById(CommandeRepository $commandeRepository,$id): Response
    {
        $commande = $commandeRepository->find($id);
        return $this->render('commande/showcommande.html.twig', [
            'controller_name' => 'CommandeController',
            'commande' => $commande,
        ]);
    }
    #[Route('/commande/getByProduit/{id}', name: 'comm_by_prod')]
    public function getByProduit($id,CommandeRepository $repository) : Response {
        $byproduits = $repository->getCommandeByProduit($id);
        return $this->render('commande/byProduit.html.twig', [
            'byproduits' => $byproduits,
            
        ]);
    }
    #[Route('/DeleteCommande/{id}', name: 'delete_commande')]
    public function DeleteCommande( ManagerRegistry $doctrine, $id): Response
    {
        $em = $doctrine->getManager();
        $dcommande = $doctrine->getRepository(Commande::class)->find($id);       

            $em->remove($dcommande);
            $em->flush();
            return $this->redirectToRoute('app_commandeapp');
        
    }
    
    #[Route('/commande/update/{id}', name: 'commande_update')]
    public function update(ManagerRegistry $doctrine,$id,Request $req): Response {
        $em = $doctrine->getManager();
        $commande = $doctrine->getRepository(Commande::class)->find($id) ;
        $form = $this->createForm(CommandeFormType::class,$commande);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em->persist($commande);
            $em->flush();
            return $this->redirectToRoute('app_commande');
        }
        return $this->renderForm('commande/add.html.twig',['form'=>$form]);

    }
 
     
}
