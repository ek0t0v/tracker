<?php

namespace App\Doctrine\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
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
     * @param User               $user
     * @param LifecycleEventArgs $event
     *
     * @ORM\PrePersist
     */
    public function prePersistHandler(User $user, LifecycleEventArgs $event)
    {
        $user->setEmailCanonical($this->generateCanonicalEmail($user->getEmail()));
        $user->setPassword($this->encoder->encodePassword($user, $user->getPlainPassword()));
        $user->setCreatedAt(new \DateTime());
    }

    /**
     * @param User               $user
     * @param PreUpdateEventArgs $event
     *
     * @ORM\PreUpdate
     */
    public function preUpdateHandler(User $user, PreUpdateEventArgs $event)
    {
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
