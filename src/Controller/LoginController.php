<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController {
    #[Route('/login', name: 'login', methods: ['GET'])]
    public function display(): Response {
        return $this->render('login/index.html.twig', []);
    }

    #[Route('/login', name: 'login_form', methods: ['POST'])]
    public function form(): Response {
        var_dump($_POST);

        return $this->render('login/index.html.twig', []);
    }
}
