<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class UserUniqueEmail.
 *
 * @Annotation
 */
class UserUniqueEmail extends Constraint
{
    /**
     * @var string
     */
    public $message = 'A user with this email address already exists.';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'user_unique_email';
    }
}
