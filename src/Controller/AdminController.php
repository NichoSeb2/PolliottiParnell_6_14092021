<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CommentRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController {
    /**
     * @Route("/admin/comment", name="app_admin_comment", options={"expose"=true})
     */
    public function comment(CommentRepository $commentRepository): Response {
        return $this->render('admin/comment.html.twig', [
            'comments' => $commentRepository->findBy([], ["createdAt" => "desc"]), 
        ]);
    }

    /**
     * @Route("/admin/category", name="app_admin_category", options={"expose"=true})
     */
    public function category(Request $request, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response {
        $category = new Category();

        $formCategory = $this->createForm(CategoryFormType::class, $category);
        $formCategory->handleRequest($request);

        if ($formCategory->isSubmitted() && $formCategory->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash("success", $translator->trans("form.category.success", [], "validators"));
        }

        return $this->render('admin/category.html.twig', [
            'formCategory' => $formCategory->createView(),
            'categories' => $categoryRepository->findBy([], ["createdAt" => "desc"]), 
        ]);
    }
}
