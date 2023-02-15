<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignUpClientType;

use App\Form\SignUpVendeurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class SignUpController extends AbstractController
{
    #[Route('/sign/up', name: 'app_sign_up')]
    public function index(): Response
    {
        return $this->render('sign_up/index.html.twig', [
            'controller_name' => 'SignUpController',
        ]);
    }
    
        #[Route('/signUpClient', name: 'app_sign_up_client')]
        public function signUpClient(Request $request,ManagerRegistry $doctrine,UserPasswordHasherInterface $passwordHasher): Response
        {  
            $entityManager = $doctrine->getManager();
            $user = new User();
            $form = $this->createForm(SignUpClientType::class, $user);
            $form->handleRequest($request);
            $plaintextPassword = "hh";
            if($form->isSubmitted()) {
                $hashedPassword = $passwordHasher->hashPassword($user,$plaintextPassword);
                $user->setPassword($hashedPassword);
                $user->setStatus(true);
                
                $entityManager-> persist($user); 
                $entityManager->flush(); 
               return $this->redirectToRoute("app_sign_up");
               
               }
                return $this->renderForm('sign_up/signUpClient.html.twig',['form'=>$form]);
            }

        #[Route('/signUpVendeur', name: 'app_sign_up_vendeur')]
        public function signUpVendeur(Request $request,ManagerRegistry $doctrine,UserPasswordHasherInterface $passwordHasher): Response
         {  
                $entityManager = $doctrine->getManager();
                $user = new User();
                $form = $this->createForm(SignUpVendeurType::class, $user);
                $form->handleRequest($request);
                $plaintextPassword = "hh";
                if($form->isSubmitted()) {
                    $hashedPassword = $passwordHasher->hashPassword($user,$plaintextPassword);
                    $user->setPassword($hashedPassword);
                    $user->setStatus(false);
                    $entityManager-> persist($user); 
                    $entityManager->flush(); 
                   return $this->redirectToRoute("app_sign_up");
                   
                }
                    return $this->renderForm('sign_up/signUpVendeur.html.twig',['form'=>$form]);
                }

}
