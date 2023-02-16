<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BillRepository;
use App\Entity\Bill;
class BillController extends AbstractController
{
    #[Route('/bill', name: 'app_bill')]
    public function index(BillRepository $billRepository, ManagerRegistry $em): Response
    {
        $bills = $em->getRepository(Bill::class)->findAll();
        return $this->render('bill/index.html.twig', [
            'controller_name' => 'BillController',
            'bills'=>$bills
        ]);
    }
   
    
}
