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
use Doctrine\ORM\Mapping as ORM;

use DateTime;

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
            $comment->setDate(new DateTime());
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('add_comment');
        }
        return $this->renderForm('comment/add.html.twig', ['form'=>$form]);

    }
    #[Route('/comment/list', name: 'list_comment')]

    public function showAction() {

        $comment = $this->getDoctrine()->getRepository(Comment::class);
        $comment = $comment->findAll();

        return $this->render(
            'comment/list.html.twig',
            array('comment' => $comment)
        );
    }
    #[Route('/supprimerComment/{id}',name:'Comment_delete')]
    public function supprimerproduit(ManagerRegistry $doctrine,CommentRepository $commentRepository,$id){
        $em = $doctrine->getManager();
        $comment = $commentRepository->find($id);
        $em->remove($comment);
        $em->flush();
        return $this->redirectToRoute('list_comment');
    
    
    }
    
    #[Route('/updateComment/{id}', name: 'Comment_update')]
    public function updateComment(ManagerRegistry $doctrine,$id,Request $req,CommentRepository $commentRepository):Response{
        $em = $doctrine->getManager();
        $comment = $commentRepository->find($id);
        $form = $this->createForm(CommentType::class,$comment);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()){
            $comment->setDate(new DateTime());

            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('list_comment');}
    return $this->renderForm('comment/add.html.twig',['form'=>$form]);}
}