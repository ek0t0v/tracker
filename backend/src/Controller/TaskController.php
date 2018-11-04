<?php

namespace App\Controller;

use App\Entity\Task;
use App\Request\Task\AddTaskRequest;
use App\Request\Task\MoveTaskRequest;
use App\Request\Task\RenameTaskRequest;
use App\Service\Task\TaskManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController.
 *
 * @Route("/api/task")
 */
class TaskController extends ApiController
{
    /**
     * @return JsonResponse
     *
     * @Route(name="api_task_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $tasks = $this->getDoctrine()->getRepository(Task::class)->findBy([], [
            'position' => 'asc',
        ]);

        return $this->apiResponse($tasks, ['frontend']);
    }

    /**
     * @param AddTaskRequest       $request
     * @param TaskManagerInterface $taskManager
     *
     * @return JsonResponse
     *
     * @Route(name="api_task_add_task", methods={"POST"})
     */
    public function add(AddTaskRequest $request, TaskManagerInterface $taskManager): JsonResponse
    {
        $task = $taskManager->add($request->name);

        return $this->apiResponse($task, ['frontend'], Response::HTTP_CREATED);
    }

    /**
     * @param Task                 $task
     * @param RenameTaskRequest    $request
     * @param TaskManagerInterface $taskManager
     *
     * @return JsonResponse
     *
     * @Route("/{id}/name", name="api_task_rename_task", methods={"POST"})
     */
    public function rename(Task $task, RenameTaskRequest $request, TaskManagerInterface $taskManager): JsonResponse
    {
        $task = $taskManager->rename($task, $request->name);

        return $this->apiResponse($task, ['frontend']);
    }

    /**
     * @param Request              $request
     * @param TaskManagerInterface $taskManager
     *
     * @return JsonResponse
     *
     * @Route(name="api_task_remove_tasks_by_ids", methods={"DELETE"})
     */
    public function remove(Request $request, TaskManagerInterface $taskManager): JsonResponse
    {
        $taskManager->remove(json_decode($request->getContent(), true)['ids']);

        return $this->apiResponse();
    }

    /**
     * @param Task                 $task
     * @param MoveTaskRequest      $request
     * @param TaskManagerInterface $taskManager
     *
     * @return JsonResponse
     *
     * @Route("/{id}/move", name="api_task_move_task", methods={"POST"})
     */
    public function move(Task $task, MoveTaskRequest $request, TaskManagerInterface $taskManager): JsonResponse
    {
        $taskManager->move($task, $request->position);

        return $this->apiResponse();
    }
}
