<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CommandeRepository;
use App\Entity\Commande;
class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(CommandeRepository $CommandeRepository, ManagerRegistry $em): Response
    {
        $produits = $em->getRepository(Commande::class)->findAll();
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'produits'=>$produits
        ]);
    }
    #[Route('/DelCommande/{id}', name: 'delete_produit_commande')]
    public function DeleteCommandee( ManagerRegistry $doctrine, $id): Response
    {
        $em = $doctrine->getManager();
        $commandep = $doctrine->getRepository(Commande::class)->find($id);       

            $em->remove($commandep);
            $em->flush();
            return $this->redirectToRoute('app_cart');
        
    }
    
   
    
}
