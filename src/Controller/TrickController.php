<?php

namespace App\Controller;

use DateTime;
use App\Entity\Trick;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrickController extends AbstractController {
    /**
     * @Route("/trick/{slug}", name="app_trick", options={"expose"=true})
     */
    public function trick(Trick $trick): Response {
        return $this->render('trick/trick.html.twig', [
            'trick' => $trick, 
        ]);
    }
}
