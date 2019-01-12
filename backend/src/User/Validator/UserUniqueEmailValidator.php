<?php

namespace User\Validator;

use User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class UserUniqueEmailValidator.
 */
class UserUniqueEmailValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * UserUniqueEmailValidator constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $user = $this->em->getRepository(User::class)->findOneBy([
            'emailCanonical' => mb_convert_case($value, MB_CASE_LOWER),
        ]);

        if ($user) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
