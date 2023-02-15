<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Repository\ProductRepository;

class DetailController extends AbstractController
{
    #[Route('/detail', name: 'app_detail')]
    public function index(ProductRepository $productRepository): Response
    { $listProduct = $productRepository->findAll();
        return $this->render('detail/index.html.twig', [
            'controller_name' => 'DetailController',
            'product' => $listProduct,

        ]);
    }
  
}
