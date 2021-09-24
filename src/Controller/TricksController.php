<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController {
    #[Route('/tricks/{slug}', name: 'tricks')]
    public function index(string $slug): Response {
        return $this->render('tricks/tricks.html.twig', [
            'tricks' => [
                'slug' => $slug, 
                'name' => "Test name", 
                'category' => "Lorem, ipsum.", 
                'description' => "Ad eiusmod laborum est cillum do minim irure amet voluptate sit aliquip cupidatat. Aliquip cupidatat deserunt eiusmod labore ex. Adipisicing incididunt exercitation quis tempor occaecat esse laboris. Exercitation eu minim nisi duis pariatur elit amet veniam excepteur minim non.\nAd eiusmod laborum est cillum do minim irure amet voluptate sit aliquip cupidatat. Aliquip cupidatat deserunt eiusmod labore ex. Adipisicing incididunt exercitation quis tempor occaecat esse laboris. Exercitation eu minim nisi duis pariatur elit amet veniam excepteur minim non.", 
                'createdAt' => new DateTime(), 
                'updatedAt' => new DateTime(), 
            ],
        ]);
    }
}
