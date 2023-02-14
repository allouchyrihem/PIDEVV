<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Form\CategoryType;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    
    }
    #[Route('/addCategory',name:'app_category_add')]
public function ajouterCategory(ManagerRegistry $doctrine,Request $req): Response{
    $em = $doctrine->getManager();
    $category = new Catgory();
    $form = $this->createForm(CategoryType::class,$category);
    $form->handleRequest($req);
    if ($form->isSubmitted()){
        $em->persist($category);
        $em->flush();
        return $this->redirectToRoute('app_club_affiche');
    }
    return $this->renderForm('category/index.html.twig',[
            'FormCategory'=>$form,
    ]);
}
}
