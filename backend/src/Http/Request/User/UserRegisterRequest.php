<?php

namespace App\Http\Request\User;

use App\Http\RequestDTOInterface;
use App\Validator\Constraints\UserUniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserRegisterRequest.
 */
class UserRegisterRequest implements RequestDTOInterface
{
    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Email()
     * @UserUniqueEmail()
     */
    public $email;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=6
     * )
     */
    public $password;
}
