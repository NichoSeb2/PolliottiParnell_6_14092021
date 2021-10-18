<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterFormType;
use Symfony\Component\Uid\Uuid;
use App\Form\VerifyResendFormType;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\VerificationMailGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController {
    /**
     * @Route("/login", name="app_login", options={"expose"=true})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout", options={"expose"=true})
     */
    public function logout() {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/register", name="app_register", options={"expose"=true})
     */
    public function register(Request $request, UserPasswordHasherInterface $passwordEncoder, MailerInterface $mailer, VerificationMailGenerator $verificationMailGenerator, TranslatorInterface $translator): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $user = new User();

        $form = $this->createForm(RegisterFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setVerificationToken(Uuid::v4());

            $verificationLink = "http://". $_SERVER['HTTP_HOST']. $this->generateUrl("app_verify", [
                'token' => $user->getVerificationToken(), 
            ]);

            // send verification mail
            $mailer->send($verificationMailGenerator->getVerificationMail($user, $verificationLink));

            // persist entity 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->render('security/register.html.twig', [
                'form' => $form->createView(),
                'success' => $translator->trans("form.register.success", [], "validators")
            ]);
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/resend", name="app_verify_resend", options={"expose"=true})
     */
    public function resend(Request $request, MailerInterface $mailer, UserRepository $userRepository, TranslatorInterface $translator, VerificationMailGenerator $verificationMailGenerator): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(VerifyResendFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneBy(['email' => $form->getData()['email']]);

            if (!is_null($user)) {
                if (!$user->isVerified()) {
                    $verificationLink = "http://". $_SERVER['HTTP_HOST']. $this->generateUrl("app_verify", [
                        'token' => $user->getVerificationToken(), 
                    ]);

                    $mailer->send($verificationMailGenerator->getVerificationMail($user, $verificationLink));

                    return $this->render('security/verify_resend.html.twig', [
                        'form' => $form->createView(),
                        'success' => $translator->trans("form.verify.resend.success", [], "validators")
                    ]);
                } else {
                    $form->get("email")->addError(new FormError($translator->trans("form.verify.resend.email.already-verified", [], "validators")));
                }
            } else {
                $form->get("email")->addError(new FormError($translator->trans("form.verify.resend.email.not-found", [], "validators")));
            }
        }

        return $this->render('security/verify_resend.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/{token}", name="app_verify", options={"expose"=true})
     */
    public function verify(string $token, UserRepository $userRepository, EntityManagerInterface $manager, TranslatorInterface $translator): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $user = $userRepository->findOneBy(['verificationToken' => $token]);

        if (!is_null($user)) {
            $user
                ->setIsVerified(true)
                ->setVerificationToken(null)
            ;
            $manager->persist($user);
            $manager->flush();

            return $this->render('security/verify.html.twig', [
                'success' => $translator->trans("form.verify.success", [], "validators")
            ]);
        }

        return $this->render('security/verify.html.twig', [
            'error' => true, 
        ]);
    }

    /**
     * @Route("/reset_password/{token}", name="app_reset_password", options={"expose"=true})
     */
    public function reset_password(string $token): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('security/reset_password.html.twig', [
            'token' => $token, 
        ]);
    }

    /**
     * @Route("/forgot_password", name="app_forgot_password", options={"expose"=true})
     */
    public function forgot_password(): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('security/forgot_password.html.twig', []);
    }
}
