<?php

namespace App\Service;

use App\Entity\User;
use App\Service\MailGenerator;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class VerificationMailGenerator extends MailGenerator {
    public function getVerificationMail(User $user, string $verificationLink): TemplatedEmail {
		$subject = 'Vérification de votre compte';

		return $this->generateMail(
			new Address($_SERVER['MAILER_NO_REPLY_EMAIL'], "SnowTricks"), 
			new Address($user->getEmail(), $user->getUserIdentifier()), 
			$subject, 
			"Bonjour, pour vérifier votre compte merci de suivre le lien ci-dessous :\n\n". $verificationLink, 
			"account_verification", [
				'subject' => $subject, 
				'link' => $verificationLink
			]
		);
    }
}
