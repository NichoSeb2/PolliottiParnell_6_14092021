<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController {
    /**
     * @Route("/admin/comment", name="app_admin_comment", options={"expose"=true})
     */
    public function comment(CommentRepository $commentRepository): Response {
        return $this->render('admin/comment.html.twig', [
            'comments' => $commentRepository->findBy([], ["createdAt" => "desc"]), 
        ]);
    }
}
