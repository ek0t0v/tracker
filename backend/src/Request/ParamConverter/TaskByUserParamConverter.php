<?php

namespace App\Request\ParamConverter;

use App\Entity\Task;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class TaskByUserParamConverter.
 *
 * todo: пофиксить - срабатывает при запросах когда должна происходить ошибка 401, не может выполнить ->getUser
 */
class TaskByUserParamConverter implements ParamConverterInterface
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * @var User
     */
    private $user;

    /**
     * TaskByUserParamConverter constructor.
     *
     * @param ManagerRegistry|null  $registry
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(ManagerRegistry $registry = null, TokenStorageInterface $tokenStorage)
    {
        $this->registry = $registry;
        $this->user = $tokenStorage->getToken()->getUser();
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        if (is_null($request->attributes->get('id'))) {
            throw new \InvalidArgumentException('Route attribute is missing.');
        }

        $em = $this->registry->getManagerForClass($configuration->getClass());
        $task = $em->getRepository($configuration->getClass())->findOneBy([
            'id' => $request->attributes->get('id'),
            'user' => $this->user,
        ]);

        if (is_null($task) || !($task instanceof Task)) {
            throw new NotFoundHttpException(sprintf('%s object not found.', $configuration->getClass()));
        }

        $request->attributes->set($configuration->getName(), $task);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        if (Task::class !== $configuration->getClass() || is_null($this->registry) || !count($this->registry->getManagers())) {
            return false;
        }

        $em = $this->registry->getManagerForClass($configuration->getClass());

        return Task::class === $em->getClassMetadata($configuration->getClass())->getName();
    }
}
