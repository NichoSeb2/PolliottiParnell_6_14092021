<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

class UserVerifiedChecker implements UserCheckerInterface {
    public function checkPreAuth(UserInterface $user): void {
        if (!$user instanceof User) {
            return;
        }
    }

    public function checkPostAuth(UserInterface $user): void {
        if (!$user instanceof User) {
            return;
        }

        // user account is not verified
        if (!$user->isVerified()) {
            throw new CustomUserMessageAccountStatusException("Votre compte n'est pas vérifier.");
        }
    }
}