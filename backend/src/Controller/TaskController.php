<?php

namespace App\Controller;

use App\Entity\Task;
use App\Request\Task\UpdateTaskPositionRequest;
use App\Request\Task\UpdateTaskStateRequest;
use App\Request\Task\CreateTaskRequest;
use App\Request\Task\GetTasksRequest;
use App\Request\Task\TransferTaskRequest;
use App\Service\Task\TaskFacade;
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
     * @param TaskFacade      $taskFacade
     *
     * @throws \Exception
     *
     * @return JsonResponse
     *
     * @Route(name="api_tasks_get_tasks", methods={"GET"})
     */
    public function getTasks(GetTasksRequest $request, TaskFacade $taskFacade): JsonResponse
    {
        $tasks = is_null($request->end)
            ? $taskFacade->getTasksByDate(new \DateTime($request->start))
            : $taskFacade->getTasksByDateRange(new \DateTime($request->start), new \DateTime($request->end));

        return $this->apiResponse([
            'items' => $tasks,
        ]);
    }

    /**
     * @param TaskFacade $taskFacade
     *
     * @return JsonResponse
     *
     * @Route("/overdue", name="api_tasks_get_overdue_tasks", methods={"GET"})
     */
    public function getOverdueTasks(TaskFacade $taskFacade)
    {
        return $this->apiResponse($taskFacade->getOverdueTasks(), ['api']);
    }

    /**
     * @param CreateTaskRequest $request
     * @param TaskFacade        $taskFacade
     *
     * @return JsonResponse
     *
     * @Route(name="api_tasks_create_task", methods={"POST"})
     */
    public function createTask(CreateTaskRequest $request, TaskFacade $taskFacade): JsonResponse
    {
        $start = new \DateTime($request->start);
        $end = !is_null($request->end) ? new \DateTime($request->end) : null;

        $task = $taskFacade->createTask($request->name, $start, $end, $request->repeatType, $request->repeatValue);

        return $this->apiResponse($task, ['api'], Response::HTTP_CREATED);
    }

    /**
     * @param Task $task
     *
     * @return JsonResponse
     *
     * @Route("/{id}", name="api_tasks_remove_task", methods={"DELETE"})
     * @ParamConverter("task", class="App:Task")
     */
    public function removeTask(Task $task): JsonResponse
    {
        $em = $this->get('doctrine')->getManager();
        $em->remove($task);
        $em->flush();

        return $this->apiResponse($task, ['api']);
    }

    /**
     * @param Task                $task
     * @param \DateTime           $forDate
     * @param TransferTaskRequest $request
     * @param TaskFacade          $taskFacade
     *
     * @return JsonResponse
     *
     * @Route("/{id}/{forDate}/transfer", name="api_tasks_transfer_task", methods={"PUT"})
     * @ParamConverter("task", converter="scheduled_task_by_user")
     * @ParamConverter("forDate", options={"format": "Y-m-d"})
     */
    public function transferTask(Task $task, \DateTime $forDate, TransferTaskRequest $request, TaskFacade $taskFacade): JsonResponse
    {
        $task = $taskFacade->transferTask($task, $forDate, new \DateTime($request->to));

        return $this->apiResponse($task, ['api']);
    }

    /**
     * @param Task                   $task
     * @param \DateTime              $forDate
     * @param UpdateTaskStateRequest $request
     * @param TaskFacade             $taskFacade
     *
     * @return JsonResponse
     *
     * @Route("/{id}/{forDate}/state", name="api_tasks_update_task_state", methods={"PUT"})
     * @ParamConverter("task", converter="scheduled_task_by_user")
     * @ParamConverter("forDate", options={"format": "Y-m-d"})
     */
    public function updateTaskState(Task $task, \DateTime $forDate, UpdateTaskStateRequest $request, TaskFacade $taskFacade): JsonResponse
    {
        $task = $taskFacade->updateTaskState($task, $forDate, $request->state);

        return $this->apiResponse($task, ['api']);
    }

    /**
     * @param Task                      $task
     * @param \DateTime                 $forDate
     * @param UpdateTaskPositionRequest $request
     * @param TaskFacade                $taskFacade
     *
     * @return JsonResponse
     *
     * @Route("/{id}/{forDate}/position", name="api_tasks_update_task_position", methods={"PUT"})
     * @ParamConverter("task", converter="scheduled_task_by_user")
     * @ParamConverter("forDate", options={"format": "Y-m-d"})
     */
    public function updateTaskPosition(Task $task, \DateTime $forDate, UpdateTaskPositionRequest $request, TaskFacade $taskFacade): JsonResponse
    {
        $task = $taskFacade->updateTaskPosition($task, $forDate, $request->position);

        return $this->apiResponse($task, ['api']);
    }
}
