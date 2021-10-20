<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class VerificationMailGenerator {
    public function getVerificationMail(User $user, string $verificationLink): TemplatedEmail {
		$subject = 'Vérification de votre compte';

        return (new TemplatedEmail())
			->from(new Address($_SERVER['MAILER_NO_REPLY_EMAIL'], "SnowTricks"))
			->to(new Address($user->getEmail(), $user->getUserIdentifier()))
			->subject($subject)
			->text("Bonjour, pour vérifier votre compte merci de suivre le lien ci-dessous :\n\n". $verificationLink)
			->htmlTemplate('emails/account_verification.html.twig')
			->context([
				'subject' => $subject, 
				'link' => $verificationLink
			])
		;
    }
}