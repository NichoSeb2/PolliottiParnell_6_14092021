<?php

namespace App\Controller;

use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrickController extends AbstractController {
    #[Route('/trick/{slug}', name: 'app_trick')]
    public function trick(string $slug): Response {
        return $this->render('trick/trick.html.twig', [
            'trick' => [
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
