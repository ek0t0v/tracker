<?php

namespace App\Doctrine\EventListener;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserListener.
 */
final class UserListener
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserListener constructor.
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param User $user
     *
     * @ORM\PrePersist()
     */
    public function prePersist(User $user)
    {
        $user->setEmailCanonical($this->generateCanonicalEmail($user->getEmail()));
        $user->setPassword($this->encoder->encodePassword($user, $user->getPlainPassword()));
        $user->setCreatedAt(new \DateTime());
    }

    /**
     * @param string $email
     *
     * @return string
     */
    private function generateCanonicalEmail(string $email)
    {
        if (is_null($email)) {
            return;
        }

        $encoding = mb_detect_encoding($email);

        return $encoding
            ? mb_convert_case($email, MB_CASE_LOWER, $encoding)
            : mb_convert_case($email, MB_CASE_LOWER);
    }
}
