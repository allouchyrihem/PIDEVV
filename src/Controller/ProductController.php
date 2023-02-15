<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Form\ProductType;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends AbstractController
{
    #[Route('/index', name: 'app_product')]
    public function index(ProductRepository $productRepository,CategoryRepository $categoryRepository): Response
    {   $listProduct = $productRepository->findAll();
        $category = $categoryRepository->findAll();

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'product' => $listProduct,
            'category' => $category,


            
        ]);
    
    }
    
    #[Route('/productAllAdmin', name:'app_product_all_admin')]
    public function productall(ProductRepository $productRepository): Response
    {
        $listProduct = $productRepository->findAll();

        return $this->render('product/producta.html.twig', [
            'controller_name' => 'ProductCotroller',
            'product' => $listProduct,
        ]);
      
    }
    
    #[Route('/product/{id}', name: 'app_product_id')]
    public function productById(ProductRepository $productRepository,$id): Response
    {
        $product = $productRepository->find($id);
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'product' => $product,
        ]);
    }
    #[Route('/addProduct', name: 'add_product')]
    public function ajouterProduit(ManagerRegistry $doctrine,Request $req): Response{
        $em = $doctrine->getManager();
        $product = new Product();
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()){
            $imageFile = $form->get('imagep')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
    
                try {
                    $imageFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception
                }
    
                $product->setImagep($newFilename);
            }
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('app_product');
        }
        return $this->renderForm('product/add.html.twig',[
                'FormProduit'=>$form,
        ]);
    }
    
    #[Route('/updateProduct/{id}', name: 'app_product_update')]
    public function updateproduit(ManagerRegistry $doctrine,$id,Request $req,ProductRepository $productRepository):Response{
        $em = $doctrine->getManager();
        $product = $productRepository->find($id);
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()){
            $imageFile = $form->get('imagep')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
    
                try {
                    $imageFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception
                }
    
                $product->setImagep($newFilename);
            }
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('app_product_all_admin');}
    return $this->renderForm('product/add.html.twig',['FormProduit'=>$form]);}
    
    #[Route('/supprimerProduct/{id}',name:'app_product_delete')]
    public function supprimerproduit(ManagerRegistry $doctrine,ProductRepository $productRepository,$id){
        $em = $doctrine->getManager();
        $product = $productRepository->find($id);
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('app_product_all_admin');
    
    
    }

}
