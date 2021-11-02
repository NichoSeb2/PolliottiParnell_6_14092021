<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\TrickRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController {
    public const INITIAL_COMMENTS_DISPLAYED = 5;
    public const ADDITIONAL_COMMENTS_DISPLAYED = 5;

    /**
     * @Route("/comment_load_more/{loaded}/{to_load}/{parent_id}", name="app_comment_load_more", options={"expose"=true})
     */
    public function load_more(int $loaded, int $to_load, int $parent_id, TrickRepository $trickRepository, CommentRepository $commentRepository): Response {
        $trick = $trickRepository->findOneBy(['id' => $parent_id]);

        $comments = $commentRepository->findBy(['trick' => $trick, 'status' => true], ['createdAt' => "DESC"], $to_load, $loaded);

        $response = new Response($this->render('comment/comment_load_more.html.twig', [
            'comments' => $comments, 
        ]));

        $response->headers->set("Total-Element-Count", sizeof($commentRepository->findBy(['trick' => $trick, 'status' => true])));

        return $response;
    }

    /**
     * @Route("/comment/put/{id}/{status}", name="app_comment_update_status", options={"expose"=true})
     */
    public function update_status(Comment $comment, string $status, EntityManagerInterface $entityManager): Response {
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
