<?php

namespace User\Doctrine\EventListener;

use User\Entity\User;
use Common\Util\Canonicalizer;
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
     * @var Canonicalizer
     */
    private $canonicalizer;

    /**
     * UserListener constructor.
     *
     * @param UserPasswordEncoderInterface $encoder
     * @param Canonicalizer                $canonicalizer
     */
    public function __construct(UserPasswordEncoderInterface $encoder, Canonicalizer $canonicalizer)
    {
        $this->encoder = $encoder;
        $this->canonicalizer = $canonicalizer;
    }

    /**
     * @param User $user
     *
     * @ORM\PrePersist
     */
    public function prePersist(User $user)
    {
        $user->setEmailCanonical($this->canonicalizer->canonicalizeEmail($user->getEmail()));
        $user->setPassword($this->encoder->encodePassword($user, $user->getPlainPassword()));
        $user->setCreatedAt(new \DateTime());
    }
}
