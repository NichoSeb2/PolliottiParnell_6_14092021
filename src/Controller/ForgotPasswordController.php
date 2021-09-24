<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForgotPasswordController extends AbstractController {
    #[Route('/forgot_password', name: 'forgot_password', methods: ['GET'])]
    public function display(): Response {
        return $this->render('forgot_password/index.html.twig', []);
    }

    #[Route('/forgot_password', name: 'forgot_password_form', methods: ['POST'])]
    public function form(): Response {
        var_dump($_POST);

        return $this->render('forgot_password/index.html.twig', []);
    }
}
