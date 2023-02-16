<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProductRepository;
use App\Entity\Product;
class DetailController extends AbstractController
{
    #[Route('/detail', name: 'app_detail')]
    public function index(ProductRepository $ProductRepository, ManagerRegistry $em): Response
    {
        $details = $em->getRepository(Product::class)->findAll();
        return $this->render('detail/index.html.twig', [
            'controller_name' => 'DetailController',
            'details'=>$details
        ]);
    }
    
    #[Route('/product/{id}', name: 'app_product_id')]
    public function productById(ProductRepository $productRepository,$id): Response
    {
        $product = $productRepository->find($id);
        return $this->render('product/showproduct.html.twig', [
            'controller_name' => 'ProductController',
            'product' => $product,
        ]);
    }
    #[Route('/addCommande', name: 'add_commande')]
    public function addCommande(CommandeRepository $commandeRepository, ManagerRegistry $doctrine, Request $req): Response
    {
        $em = $doctrine->getManager();
        $commande = new Commande();
        $form = $this->createForm(CommandeFormType::class,$commande);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em->persist($commande);
            $em->flush();
            return $this->redirectToRoute('app_cart');
        }
        return $this->renderForm('commande/add.html.twig',['form'=>$form]);

    }
}
