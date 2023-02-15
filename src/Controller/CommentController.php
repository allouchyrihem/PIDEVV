<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CommentType;
use App\Entity\Comment;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CommentRepository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


class CommentController extends AbstractController
{
    #[Route('/comment', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    #[Route('/comment/add', name: 'add_comment')]
    public function addComment(ManagerRegistry $doctrine , Request $req):Response{
        $em=$doctrine->getManager();
        $comment= new Comment();
        $form = $this->createForm(CommentType::class,$comment);
        $form->handleRequest($req);
        if($form->isSubmitted()&& $form->isValid()){
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('add_comment');
        }
        return $this->renderForm('comment/add.html.twig', ['form'=>$form]);

    }

}
