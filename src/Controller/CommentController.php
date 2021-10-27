<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController {
    public const INITIAL_COMMENTS_DISPLAYED = 1;
    public const ADDITIONAL_COMMENTS_DISPLAYED = 2;

    /**
     * @Route("/comment_load_more/{loaded}/{to_load}", name="app_comment_load_more", options={"expose"=true})
     */
    public function load_more(int $loaded, int $to_load, CommentRepository $commentRepository): Response {
        $comments = $commentRepository->findBy([], ['createdAt' => "DESC"], $to_load, $loaded);

        return $this->render('comment/comment_load_more.html.twig', [
            'comments' => $comments, 
        ]);
    }
}
