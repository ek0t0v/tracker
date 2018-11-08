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
        $id = $request->attributes->get('id');

        if (is_null($id)) {
            throw new \InvalidArgumentException('Route attribute is missing.');
        }

        $em = $this->registry->getManagerForClass($configuration->getClass());
        $taskRepository = $em->getRepository($configuration->getClass());

        $task = $taskRepository->findOneBy([
            'id' => $id,
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
        if (Task::class !== $configuration->getClass()) {
            return false;
        }

        if (is_null($this->registry) || !count($this->registry->getManagers())) {
            return false;
        }

        $em = $this->registry->getManagerForClass($configuration->getClass());

        return Task::class === $em->getClassMetadata($configuration->getClass())->getName();
    }
}
