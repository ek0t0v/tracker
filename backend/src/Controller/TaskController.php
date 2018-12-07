<?php

namespace App\Controller;

use App\Entity\Task;
use App\Request\Task\ChangeTaskPositionRequest;
use App\Request\Task\ChangeTaskStateRequest;
use App\Request\Task\CreateTaskRequest;
use App\Request\Task\GetTasksRequest;
use App\Request\Task\TransferTaskRequest;
use App\Service\Task\TaskService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController.
 *
 * @Route("/api/tasks")
 */
class TaskController extends ApiController
{
    /**
     * @param GetTasksRequest $request
     * @param TaskService     $taskService
     *
     * @throws \Exception
     *
     * @return JsonResponse
     *
     *
     * @Route(name="api_tasks_get_tasks", methods={"GET"})
     */
    public function getTasks(GetTasksRequest $request, TaskService $taskService): JsonResponse
    {
        $tasks = is_null($request->end)
            ? $taskService->getTasksByDate(new \DateTime($request->start))
            : $taskService->getTasksByDateRange(new \DateTime($request->start), new \DateTime($request->end));

        return $this->apiResponse([
            'items' => $tasks,
        ]);
    }

    /**
     * @param CreateTaskRequest $request
     * @param TaskService       $taskService
     *
     * @return JsonResponse
     *
     * @Route(name="api_tasks_create_task", methods={"POST"})
     */
    public function createTask(CreateTaskRequest $request, TaskService $taskService): JsonResponse
    {
        $start = new \DateTime($request->start);
        $end = !is_null($request->end) ? new \DateTime($request->end) : null;

        $task = $taskService->create($request->name, $start, $end, $request->schedule);

        return $this->apiResponse($task, ['api'], Response::HTTP_CREATED);
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
