<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ForgotPasswordMailGenerator {
    public function getForgotPasswordMail(User $user, string $resetPasswordLink): TemplatedEmail {
		$subject = 'Réinitialisation de votre mot de passe';

        return (new TemplatedEmail())
			->from(new Address($_SERVER['MAILER_NO_REPLY_EMAIL'], "SnowTricks"))
			->to(new Address($user->getEmail(), $user->getUserIdentifier()))
			->subject($subject)
			->text("Bonjour, pour réinitialiser votre mot de passe merci de suivre le lien ci-dessous :\n\n". $resetPasswordLink)
			->htmlTemplate('emails/password_reset.html.twig')
			->context([
				'subject' => $subject, 
				'link' => $resetPasswordLink
			])
		;
    }
}