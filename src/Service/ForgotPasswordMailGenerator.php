<?php

namespace App\Service;

use App\Entity\User;
use App\Service\MailGenerator;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ForgotPasswordMailGenerator extends MailGenerator {
    public function getForgotPasswordMail(User $user, string $resetPasswordLink): TemplatedEmail {
		$subject = 'Réinitialisation de votre mot de passe';

		return $this->generateMail(
			new Address($_SERVER['MAILER_NO_REPLY_EMAIL'], "SnowTricks"), 
			new Address($user->getEmail(), $user->getUserIdentifier()), 
			$subject, 
			"Bonjour, pour réinitialiser votre mot de passe merci de suivre le lien ci-dessous :\n\n". $resetPasswordLink, 
			"password_reset", [
				'subject' => $subject, 
				'link' => $resetPasswordLink
			]
		);
    }
}
