<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Media;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\TrickFormType;
use App\Service\SlugConvertor;
use Symfony\Component\Uid\Uuid;
use App\Form\CreateCommentFormType;
use App\Repository\TrickRepository;
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
    public function create(Request $request, SlugConvertor $slugConvertor, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response {
        /** @var User $user */
        $user = $this->getUser();

        $trick = new Trick($slugConvertor, $entityManager);

        $formTrick = $this->createForm(TrickFormType::class, $trick);
        $formTrick->handleRequest($request);

        if ($formTrick->isSubmitted() && $formTrick->isValid()) {
            $coverImage = $formTrick->get("coverImage")->getData();

            if (str_starts_with($coverImage->getClientMimeType(), "image/")) {
                $coverImageExtension = $coverImage->guessExtension();

                // extension cannot be guessed
                if (!$coverImageExtension) {
                    $coverImageExtension = 'bin';
                }

                $coverImageTargetFileName = Uuid::v4(). '.'. $coverImageExtension;
                $coverImage->move(Media::UPLOAD_DIR, $coverImageTargetFileName);
                $coverImageTargetPath = str_replace("./", "/", Media::UPLOAD_DIR). $coverImageTargetFileName;

                $coverImage = (new Media())
                    ->setUrl($coverImageTargetPath)
                    ->setAlt($trick->getName())
                ;

                $trick
                    ->setAuthor($user)
                    ->setCoverImage($coverImage)
                    ->updateSlug()
                ;

                $entityManager->persist($coverImage);
                $entityManager->persist($trick);

                $entityManager->flush();

                return $this->render('trick/trick_create.html.twig', [
                    'formTrick' => $formTrick->createView(),
                    'trickSuccess' => $translator->trans("form.create-trick.success", [], "validators"),
                ]);
            } else {
                $formTrick->get("coverImage")->addError(new FormError($translator->trans("form.create-trick.coverImage.wrong-mime-type", [], "validators")));
            }
        }

        return $this->render('trick/trick_create.html.twig', [
            'formTrick' => $formTrick->createView(),
        ]);
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
