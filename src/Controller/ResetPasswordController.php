<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController {
    #[Route('/reset_password/{token}', name: 'reset_password', methods: ['GET'])]
    public function display(string $token): Response {
        return $this->render('reset_password/index.html.twig', [
            'token' => $token, 
        ]);
    }

    #[Route('/reset_password/{token}', name: 'reset_password_form', methods: ['POST'])]
    public function form(string $token): Response {
        var_dump($token, $_POST);

        return $this->render('reset_password/index.html.twig', [
            'token' => $token, 
        ]);
    }
}
