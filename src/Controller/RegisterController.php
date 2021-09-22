<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController {
    #[Route('/register', name: 'register', methods: ['GET'])]
    public function display(): Response {
        return $this->render('register/index.html.twig', []);
    }

    #[Route('/register', name: 'register_form', methods: ['POST'])]
    public function form(): Response {
        var_dump($_POST);

        return $this->render('register/index.html.twig', []);
    }
}
