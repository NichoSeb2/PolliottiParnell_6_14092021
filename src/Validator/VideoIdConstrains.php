<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class VideoIdConstrains extends Constraint {
    public $message = "The url do not contains a valid video id.";
}
