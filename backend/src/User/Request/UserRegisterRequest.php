<?php

namespace User\Request;

use Common\Http\RequestDtoInterface;
use User\Validator\Constraint\UserUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserRegisterRequest.
 */
class UserRegisterRequest implements RequestDtoInterface
{
    /**
     * @var string
     *
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Email
     * @UserUniqueEmail
     */
    public $email;

    /**
     * @var string
     *
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Length(
     *     min=6
     * )
     */
    public $password;
}
