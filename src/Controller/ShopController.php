<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
class ShopController extends AbstractController
{
   
    #[Route('/shop', name:'app_shop')]
    public function productall(ProductRepository $productRepository): Response
    {
        $listProduct = $productRepository->findAll();

        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'product' => $listProduct,
        ]);
      
    }
}
