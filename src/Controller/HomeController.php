<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {
    /**
     * @Route("/", name="app_home", options={"expose"=true})
     */
    public function home(TrickRepository $trickRepository): Response {
        $tricks = $trickRepository->findBy([], ['createdAt' => "DESC"], TrickController::INITIAL_TRICKS_DISPLAYED);

        return $this->render('home/index.html.twig', [
            'ADDITIONAL_TRICKS_DISPLAYED' => TrickController::ADDITIONAL_TRICKS_DISPLAYED, 
            'tricks' => $tricks, 
        ]);
    }
}
