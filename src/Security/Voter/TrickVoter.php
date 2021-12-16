<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Trick;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TrickVoter extends Voter {
    const DELETE_TRICK = 'delete_trick';

	public function __construct(private Security $security) {}

    protected function supports(string $attribute, $subject): bool {
        if (!in_array($attribute, [self::DELETE_TRICK])) {
            return false;
        }

        if (!$subject instanceof Trick) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Trick $post */
        $trick = $subject;

        switch ($attribute) {
            case self::DELETE_TRICK:
                return $this->canDelete($trick, $user);
        }
    }

    private function canDelete(Trick $trick, User $user): bool {
		if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

		return $trick->getAuthor() === $user;
    }
}