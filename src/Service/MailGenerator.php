<?php

namespace App\Service;

use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailGenerator {
    protected function generateMail(Address $from, Address $to, string $subject, string $text, string $template = "default", array $context = []): TemplatedEmail {
        return (new TemplatedEmail())
			->from($from)
			->to($to)
			->subject($subject)
			->text($text)
			->htmlTemplate("emails/". $template. ".html.twig")
			->context($context)
		;
    }
}
