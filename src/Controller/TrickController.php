<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Media;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\TrickFormType;
use App\Service\TrickManager;
use App\Service\SlugConvertor;
use App\Form\CreateCommentFormType;
use App\Repository\TrickRepository;
use App\Exception\FileTypeException;
use App\Repository\CommentRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrickController extends AbstractController {
    public const INITIAL_TRICKS_DISPLAYED = 5;
    public const ADDITIONAL_TRICKS_DISPLAYED = 5;

    /**
     * @Route("/trick/create", name="app_trick_create", options={"expose"=true})
     */
    public function create(Request $request, SlugConvertor $slugConvertor, EntityManagerInterface $entityManager, TranslatorInterface $translator, TrickManager $trickManager): Response {
        /** @var User $user */
        $user = $this->getUser();

        $trick = new Trick($slugConvertor, $entityManager);

        $formTrick = $this->createForm(TrickFormType::class, $trick, ['new' => true]);
        $formTrick->handleRequest($request);

        if ($formTrick->isSubmitted() && $formTrick->isValid()) {
            try {
                $trickManager->processData($formTrick, TrickManager::CREATE_MODE, $trick, $user);
                $formTrick = $trickManager->getForm();

                $trick = $trickManager->getTrick();

                foreach ($trickManager->getMedias() as $media) {
                    $entityManager->persist($media);
                }

                $entityManager->persist($trick->getCoverImage());
                $entityManager->persist($trick);
                $entityManager->flush();

                $this->addFlash("success", $translator->trans("form.create-trick.success", [], "validators"));

                return $this->redirectToRoute("app_home");
            } catch (FileTypeException $e) {
                $formTrick->get("coverImage")->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('trick/trick_create.html.twig', [
            'formTrick' => $formTrick->createView(),
        ]);
    }

    /**
     * @Route("/trick/{slug}/edit", name="app_trick_edit", options={"expose"=true})
     */
    public function edit(Trick $trick, Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator, TrickManager $trickManager): Response {
        /** @var User $user */
        $user = $this->getUser();

        $formTrick = $this->createForm(TrickFormType::class, $trick);
        $formTrick->handleRequest($request);

        if ($formTrick->isSubmitted() && $formTrick->isValid()) {
            $trickManager->processData($formTrick, TrickManager::EDIT_MODE, $trick, $user);
            $formTrick = $trickManager->getForm();

            $trick = $trickManager->getTrick();

            foreach ($trickManager->getMedias() as $media) {
                $entityManager->persist($media);
            }

            $entityManager->persist($trick->getCoverImage());
            $entityManager->persist($trick);
            $entityManager->flush();

            $this->addFlash("success", $translator->trans("form.edit-trick.success", [], "validators"));

            return $this->redirectToRoute("app_trick", [
                'slug' => $trick->getSlug(), 
            ]);
        }

        return $this->render('trick/trick_edit.html.twig', [
            'formTrick' => $formTrick->createView(),
        ]);
    }

    /**
     * @Route("/trick/{slug}/delete", name="app_trick_delete", options={"expose"=true})
     */
    public function delete(Trick $trick, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response {
        /** @var User $user */
        $user = $this->getUser();

        foreach ($trick->getMedias() as $media) {
            $entityManager->remove($media);
            $entityManager->flush();
        }

        $entityManager->remove($trick);
        $entityManager->flush();

        $this->addFlash("success", $translator->trans("form.delete-trick.success", [], "validators"));

        return $this->redirectToRoute("app_home");
    }

    /**
     * @Route("/trick/{slug}", name="app_trick", options={"expose"=true})
     */
    public function trick(Request $request, Trick $trick, CommentRepository $commentRepository, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response {
        $createCommentSuccess = null;

        /** @var User $user */
        $user = $this->getUser();
        $comment = new Comment();

        $formCreateComment = $this->createForm(CreateCommentFormType::class, $comment);
        $formCreateComment->handleRequest($request);

        if ($formCreateComment->isSubmitted() && $formCreateComment->isValid()) {
            $comment
                ->setTrick($trick)
                ->setAuthor($user)
            ;

            $entityManager->persist($comment);
            $entityManager->flush();

            $createCommentSuccess = $translator->trans("form.create-comment.success", [], "validators");
        }

        $comments = $commentRepository->findBy(['trick' => $trick, 'status' => true], ['createdAt' => "DESC"], CommentController::INITIAL_COMMENTS_DISPLAYED);
        $trick->setComments(new ArrayCollection($comments));

        return $this->render('trick/trick.html.twig', [
            'ADDITIONAL_COMMENTS_DISPLAYED' => CommentController::ADDITIONAL_COMMENTS_DISPLAYED, 
            'trick' => $trick, 
            'formCreateComment' => $formCreateComment->createView(),
            'createCommentSuccess' => $createCommentSuccess,
        ]);
    }

    /**
     * @Route("/trick_load_more/{loaded}/{to_load}", name="app_trick_load_more", options={"expose"=true})
     */
    public function load_more(int $loaded, int $to_load, TrickRepository $trickRepository): Response {
        $tricks = $trickRepository->findBy([], ['createdAt' => "DESC"], $to_load, $loaded);

        $response = new Response($this->render('trick/trick_load_more.html.twig', [
            'tricks' => $tricks, 
        ]));

        $response->headers->set("Total-Element-Count", sizeof($trickRepository->findAll()));

        return $response;
    }
}
