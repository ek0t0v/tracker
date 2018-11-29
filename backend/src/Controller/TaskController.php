<?php

namespace App\Controller;

use App\Entity\Task;
use App\Request\Task\ChangeTaskPositionRequest;
use App\Request\Task\ChangeTaskStateRequest;
use App\Request\Task\CreateTaskRequest;
use App\Request\Task\GetTasksRequest;
use App\Request\Task\TransferTaskRequest;
use App\Service\Task\TaskServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController.
 *
 * @Route("/api/tasks")
 */
class TaskController extends ApiController
{
    /**
     * @param GetTasksRequest      $request
     * @param TaskServiceInterface $taskService
     *
     * @return JsonResponse
     *
     * @Route(name="api_tasks_get_tasks", methods={"GET"})
     */
    public function getTasks(GetTasksRequest $request, TaskServiceInterface $taskService): JsonResponse
    {
        return $this->apiResponse([
            'items' => $taskService->get(new \DateTime($request->start), new \DateTime($request->end)),
        ], ['frontend']);
    }

    /**
     * @param CreateTaskRequest $request
     *
     * @return JsonResponse
     *
     * @Route(name="api_tasks_create_task", methods={"POST"})
     */
    public function createTask(CreateTaskRequest $request): JsonResponse
    {
        return $this->apiResponse();
    }

    /**
     * @param Task                $task
     * @param TransferTaskRequest $request
     *
     * @return JsonResponse
     *
     * @Route("/{id}/transfer", name="api_tasks_transfer_task", methods={"POST"})
     */
    public function transferTask(Task $task, TransferTaskRequest $request): JsonResponse
    {
        return $this->apiResponse();
    }

    /**
     * @param Task                   $task
     * @param ChangeTaskStateRequest $request
     *
     * @return JsonResponse
     *
     * @Route("/{id}/state", name="api_tasks_change_task_state", methods={"POST"})
     */
    public function changeTaskState(Task $task, ChangeTaskStateRequest $request): JsonResponse
    {
        return $this->apiResponse();
    }

    /**
     * @param Task                      $task
     * @param ChangeTaskPositionRequest $request
     *
     * @return JsonResponse
     *
     * @Route("/{id}/position", name="api_tasks_change_task_position", methods={"POST"})
     */
    public function changeTaskPosition(Task $task, ChangeTaskPositionRequest $request): JsonResponse
    {
        return $this->apiResponse();
    }
}
