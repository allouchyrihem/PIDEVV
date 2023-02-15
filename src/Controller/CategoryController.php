<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;
class CategoryController extends AbstractController
{

    #[Route('/categoryAll', name: 'app_category')]
    public function product(CategoryRepository $categoryRepository,ProductRepository $productRepository): Response
    {
        $listCategory = $categoryRepository->findAll();
        $listProduct = $productRepository->findAll();

        return $this->render('product/index.html.twig', [
            'controller_name' => 'CategoryController',
            'category' => $listCategory,
            'product'=>$listProduct
        ]);
      
    }

    #[Route('/categoryAllA', name: 'app_category_A')]
    public function categoryA(CategoryRepository $categoryRepository,ProductRepository $productRepository): Response
    {
        $listCategory = $categoryRepository->findAll();
        $listProduct = $productRepository->findAll();

        return $this->render('category/categorya.html.twig', [
            'controller_name' => 'CategoryController',
            'category' => $listCategory,
        ]);
      
    }
    
    #[Route('/category/{id}', name: 'app_category_id')]
    public function categorieById(CategoryRepository $categoryRepository,$id): Response
    {
        $category = $categoryRepository->find($id);
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'category' => $category,
        ]);
    }
     
    #[Route('/addCategory',name:'app_category_add')]
public function ajouterCategory(ManagerRegistry $doctrine,Request $req): Response{
    $em = $doctrine->getManager();
    $category = new Category();
    $form = $this->createForm(CategoryType::class,$category);
    $form->handleRequest($req);
    if ($form->isSubmitted()){
        $em->persist($category);
        $em->flush();
        return $this->redirectToRoute('app_category_A');
    }
    return $this->renderForm('category/add.html.twig',[
            'FormCategory'=>$form,
    ]);
}

#[Route('/updateCategory/{id}', name: 'app_category_update')]
public function updateCategory(ManagerRegistry $doctrine,$id,Request $req,CategoryRepository $categoryRepository):Response{
    $em = $doctrine->getManager();
    $category = $categoryRepository->find($id);
    $form = $this->createForm(CategoryType::class,$category);
    $form->handleRequest($req);
    if ($form->isSubmitted()){
        $em->persist($category);
        $em->flush();
        return $this->redirectToRoute('app_category_A');}
return $this->renderForm('category/add.html.twig',['FormCategory'=>$form]);}

#[Route('supprimerCategory/{id}',name:'app_category_delete')]
public function supprimerCategory(ManagerRegistry $doctrine,CategoryRepository $categoryRepository,$id){
    $em = $doctrine->getManager();
    $category = $categoryRepository->find($id);
    $em->remove($category);
    $em->flush();
    return $this->redirectToRoute('app_category_A');


}
}
