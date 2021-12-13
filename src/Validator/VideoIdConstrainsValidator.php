<?php

namespace App\Validator;

use App\Exception\FileTypeException;
use App\Service\TrickManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class VideoIdConstrainsValidator extends ConstraintValidator {
	public function __construct(private TrickManager $trickManager) {}

    public function validate($value, Constraint $constraint) {
        if (!$constraint instanceof VideoIdConstrains) {
            throw new UnexpectedTypeException($constraint, ContainsAlphanumeric::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

		try {
			$this->trickManager->verifyVideoUrl($value);
		} catch (FileTypeException $e) {
			$this->context->buildViolation($constraint->message)
                ->addViolation();
		}
    }
}
