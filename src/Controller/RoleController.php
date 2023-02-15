<?php

namespace App\Controller;

use App\Entity\Role;
use App\Form\AddRoleType;
use App\Repository\RoleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class RoleController extends AbstractController
{
    #[Route('/role', name: 'app_role')]
    public function index(RoleRepository $roleRepository): Response
    {
        $roles = $roleRepository->findAll();
        return $this->render('role/index.html.twig', [
            'roles' => $roles,
        ]);
    }

    #[Route('/addRole', name: 'app_add_role')]
    public function addRole(ManagerRegistry $doctrine, Request $req): Response
    {
        $entityManager = $doctrine->getManager();
        $role = new Role();
        $form = $this->createForm(AddRoleType::class, $role);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $entityManager->persist($role);
            $entityManager->flush();
            return $this->redirectToRoute('app_role');
        }
        return $this->renderForm('role/addRole.html.twig', ['form' => $form]);
    }

    #[Route('/updateRole/{id}', name: 'app_update_role')]
    public function updateRole(RoleRepository $roleRepository,$id,Request $req,ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $role = $roleRepository->find($id);
        $form = $this->createform(AddRoleType::class, $role);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $entityManager->persist($role);
            $entityManager->flush();
            return $this->redirectToRoute('app_role');
        }
        return $this->renderForm('role/addRole.html.twig', ['form' => $form]);
    }

    #[Route('/deleteRole/{id}', name: 'app_delete_role')]
    public function deleteRole(RoleRepository $roleRepository,ManagerRegistry $doctrine,$id,Request $req): Response
    {
        $role = $roleRepository->find($id);
    
        $entityManager = $doctrine->getManager();
        $entityManager->remove($role);
        $entityManager->flush();
        
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('app_role');
        }
    
    }

