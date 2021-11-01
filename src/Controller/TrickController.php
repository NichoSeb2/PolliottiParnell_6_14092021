<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrickController extends AbstractController {
    public const INITIAL_TRICKS_DISPLAYED = 1;
    public const ADDITIONAL_TRICKS_DISPLAYED = 2;

    /**
     * @Route("/trick/{slug}", name="app_trick", options={"expose"=true})
     */
    public function trick(Trick $trick, CommentRepository $commentRepository): Response {
        $comments = $commentRepository->findBy(['trick' => $trick], ['createdAt' => "DESC"], CommentController::INITIAL_COMMENTS_DISPLAYED);
        $trick->setComments($comments);

        return $this->render('trick/trick.html.twig', [
            'ADDITIONAL_COMMENTS_DISPLAYED' => CommentController::ADDITIONAL_COMMENTS_DISPLAYED, 
            'trick' => $trick, 
        ]);
    }

    /**
     * @Route("/trick_load_more/{loaded}/{to_load}", name="app_trick_load_more", options={"expose"=true})
     */
    public function load_more(int $loaded, int $to_load, TrickRepository $trickRepository): Response {
        $tricks = $trickRepository->findBy([], ['createdAt' => "DESC"], $to_load, $loaded);

        $response = new Response($this->render('trick/trick_load_more.html.twig', [
            'tricks' => $tricks, 
        ]));

        $response->headers->set("Total-Element-Count", sizeof($trickRepository->findAll()));

        return $response;
    }
}
