<?php

namespace App\Request\ParamConverter;

use App\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ScheduledTaskByUserParamConverter.
 */
class ScheduledTaskByUserParamConverter implements ParamConverterInterface
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * TaskByUserParamConverter constructor.
     *
     * @param ManagerRegistry|null  $registry
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(ManagerRegistry $registry = null, TokenStorageInterface $tokenStorage)
    {
        $this->registry = $registry;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        if (is_null($request->attributes->get('id')) || is_null($request->attributes->get('forDate'))) {
            throw new \InvalidArgumentException('Route attribute is missing.');
        }

        if (\DateTime::createFromFormat('Y-m-d', $request->attributes->get('forDate')) === false) {
            throw new \InvalidArgumentException('forDate route attribute is invalid.');
        }

        $em = $this->registry->getManagerForClass($configuration->getClass());
        $task = $em->getRepository($configuration->getClass())->findOneBy([
            'id' => $request->attributes->get('id'),
            'user' => $this->tokenStorage->getToken()->getUser(),
        ]);

        $forDate = new \DateTime($request->attributes->get('forDate'));

        if (is_null($task) || !($task instanceof Task) || !$task->isScheduled($forDate)) {
            throw new NotFoundHttpException(sprintf('%s object not found.', $configuration->getClass()));
        }

        $request->attributes->set($configuration->getName(), $task);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        if (Task::class !== $configuration->getClass() || !count($this->registry->getManagers())) {
            return false;
        }

        $em = $this->registry->getManagerForClass($configuration->getClass());

        return Task::class === $em->getClassMetadata($configuration->getClass())->getName();
    }
}
