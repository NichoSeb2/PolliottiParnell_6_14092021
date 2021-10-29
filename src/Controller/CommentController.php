<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController {
    public const INITIAL_COMMENTS_DISPLAYED = 5;
    public const ADDITIONAL_COMMENTS_DISPLAYED = 5;

    /**
     * @Route("/comment_load_more/{loaded}/{to_load}", name="app_comment_load_more", options={"expose"=true})
     */
    public function load_more(int $loaded, int $to_load, CommentRepository $commentRepository): Response {
        $comments = $commentRepository->findBy(['status' => true], ['createdAt' => "DESC"], $to_load, $loaded);

        return $this->render('comment/comment_load_more.html.twig', [
            'comments' => $comments, 
        ]);
    }

    /**
     * @Route("/comment/put/{id}/{status}", name="app_comment_update_status", options={"expose"=true})
     */
    public function update_status(Comment $comment, string $status, EntityManagerInterface $entityManager) {
        if ($status == "on") {
            $comment->setStatus(true);
        } else {
            $comment->setStatus(false);
        }

        $entityManager->persist($comment);
        $entityManager->flush();

        return (new Response())->setStatusCode(200);
    }
}
