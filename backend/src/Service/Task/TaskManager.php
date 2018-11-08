<?php

namespace App\Service\Task;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class TaskManager.
 */
class TaskManager implements TaskManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * TaskManager constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function add(string $name, User $user): Task
    {
        $task = new Task();
        $task->setName($name);
        $task->setPosition(0);
        $task->setUser($user);

        $this->em->persist($task);

        $this->em->flush();

        return $task;
    }

    /**
     * {@inheritdoc}
     *
     * todo: когда удаляем несколько элементов из середины списка, у некоторых элементов позиция не обновляется
     *
     * Удаление нескольких элементов выглядит как-то так:
     *
     * [2018-11-08 04:54:26] doctrine.DEBUG: "START TRANSACTION" [] []
     * [2018-11-08 04:54:26] doctrine.DEBUG: DELETE FROM tasks WHERE id = ? [84] []
     * [2018-11-08 04:54:26] doctrine.DEBUG: UPDATE tasks SET position = position - 1 WHERE position >= 0 [] []
     * [2018-11-08 04:54:26] doctrine.DEBUG: UPDATE tasks SET position = position - 1 WHERE position >= 1 [] []
     * [2018-11-08 04:54:26] doctrine.DEBUG: UPDATE tasks SET position = position - 1 WHERE position >= 2 [] []
     * [2018-11-08 04:54:26] doctrine.DEBUG: DELETE FROM tasks WHERE id = ? [85] []
     * [2018-11-08 04:54:26] doctrine.DEBUG: DELETE FROM tasks WHERE id = ? [86] []
     * [2018-11-08 04:54:26] doctrine.DEBUG: "COMMIT" [] []
     *
     * После удаления остальных элементов позиции не обновляются.
     */
    public function remove(array $ids, User $user)
    {
        $tasks = $this->em->getRepository(Task::class)->findBy([
            'id' => $ids,
            'user' => $user,
        ]);

        foreach ($tasks as $task) {
            $this->em->remove($task);
        }

        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function rename(Task $task, string $name): Task
    {
        $task->setName($name);

        $this->em->persist($task);

        $this->em->flush();

        return $task;
    }

    /**
     * {@inheritdoc}
     */
    public function move(Task $task, int $position): Task
    {
        $task->setPosition($position);

        $this->em->persist($task);

        $this->em->flush();

        return $task;
    }
}
