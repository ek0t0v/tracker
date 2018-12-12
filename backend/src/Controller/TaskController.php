<?php

namespace App\Controller;

use App\Entity\Task;
use App\Request\Task\UpdateTaskPositionRequest;
use App\Request\Task\UpdateTaskStateRequest;
use App\Request\Task\CreateTaskRequest;
use App\Request\Task\GetTasksRequest;
use App\Request\Task\TransferTaskRequest;
use App\Service\Task\TaskService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @param TaskService $taskService
     *
     * @return JsonResponse
     *
     * @Route("/overdue", name="api_tasks_get_overdue_tasks", methods={"GET"})
     */
    public function getOverdueTasks(TaskService $taskService)
    {
        return $this->apiResponse($taskService->getOverdueTasks(), ['api']);
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

        $task = $taskService->createTask($request->name, $start, $end, $request->schedule);

        return $this->apiResponse($task, ['api'], Response::HTTP_CREATED);
    }

    /**
     * @param Task                $task
     * @param \DateTime           $forDate
     * @param TransferTaskRequest $request
     * @param TaskService         $taskService
     *
     * @return JsonResponse
     *
     * @Route("/{id}/{forDate}/transfer", name="api_tasks_transfer_task", methods={"PUT"})
     * @ParamConverter("task", converter="scheduled_task_by_user")
     * @ParamConverter("forDate", options={"format": "Y-m-d"})
     */
    public function transferTask(Task $task, \DateTime $forDate, TransferTaskRequest $request, TaskService $taskService): JsonResponse
    {
        $task = $taskService->transferTask($task, $forDate, new \DateTime($request->to));

        return $this->apiResponse($task, ['api']);
    }

    /**
     * @param Task                   $task
     * @param \DateTime              $forDate
     * @param UpdateTaskStateRequest $request
     * @param TaskService            $taskService
     *
     * @return JsonResponse
     *
     * @Route("/{id}/{forDate}/state", name="api_tasks_update_task_state", methods={"PUT"})
     * @ParamConverter("task", converter="scheduled_task_by_user")
     * @ParamConverter("forDate", options={"format": "Y-m-d"})
     */
    public function updateTaskState(Task $task, \DateTime $forDate, UpdateTaskStateRequest $request, TaskService $taskService): JsonResponse
    {
        $task = $taskService->updateTaskState($task, $forDate, $request->state);

        return $this->apiResponse($task, ['api']);
    }

    /**
     * @param Task                      $task
     * @param \DateTime                 $forDate
     * @param UpdateTaskPositionRequest $request
     * @param TaskService               $taskService
     *
     * @return JsonResponse
     *
     * @Route("/{id}/{forDate}/position", name="api_tasks_update_task_position", methods={"PUT"})
     * @ParamConverter("task", converter="scheduled_task_by_user")
     * @ParamConverter("forDate", options={"format": "Y-m-d"})
     */
    public function updateTaskPosition(Task $task, \DateTime $forDate, UpdateTaskPositionRequest $request, TaskService $taskService): JsonResponse
    {
        $task = $taskService->updateTaskPosition($task, $forDate, $request->position);

        return $this->apiResponse($task, ['api']);
    }
}
