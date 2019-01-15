<?php

namespace Task\Service;

use Task\Dto\Response\TaskDto;
use Task\Entity\Task;

/**
 * Class TaskFacade.
 */
class TaskFacade
{
    /**
     * @var CreateResponseDto
     */
    private $createResponseDtoService;

    /**
     * @var GetTasksByDate
     */
    private $getTasksByDateService;

    /**
     * @var GetOverdueTasks
     */
    private $getOverdueTasksService;

    /**
     * @var CreateTask
     */
    private $createTaskService;

    /**
     * @var UpdateTaskState
     */
    private $updateTaskStateService;

    /**
     * @var UpdateTaskPosition
     */
    private $updateTaskPositionService;

    /**
     * @var TransferTask
     */
    private $transferTaskService;

    /**
     * TaskFacade constructor.
     *
     * @param CreateResponseDto  $createResponseDtoService
     * @param GetTasksByDate     $getTasksByDateService
     * @param GetOverdueTasks    $getOverdueTasksService
     * @param CreateTask         $createTaskService
     * @param UpdateTaskState    $updateTaskStateService
     * @param UpdateTaskPosition $updateTaskPositionService
     * @param TransferTask       $transferTaskService
     */
    public function __construct(
        CreateResponseDto $createResponseDtoService,
        GetTasksByDate $getTasksByDateService,
        GetOverdueTasks $getOverdueTasksService,
        CreateTask $createTaskService,
        UpdateTaskState $updateTaskStateService,
        UpdateTaskPosition $updateTaskPositionService,
        TransferTask $transferTaskService
    ) {
        $this->createResponseDtoService = $createResponseDtoService;
        $this->getTasksByDateService = $getTasksByDateService;
        $this->getOverdueTasksService = $getOverdueTasksService;
        $this->createTaskService = $createTaskService;
        $this->updateTaskStateService = $updateTaskStateService;
        $this->updateTaskPositionService = $updateTaskPositionService;
        $this->transferTaskService = $transferTaskService;
    }

    /**
     * @param \DateTime $date
     *
     * @return TaskDto[]
     */
    public function getTasksByDate(\DateTime $date): array
    {
        $result = [];

        foreach ($this->getTasksByDateService->getByDate($date) as $task) {
            $result[] = $this->createResponseDtoService->create($task['task'], $task['forDate']);
        }

        return $result;
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @throws \Exception
     *
     * @return TaskDto[]
     */
    public function getTasksByDateRange(\DateTime $start, \DateTime $end): array
    {
        $result = [];

        foreach ($this->getTasksByDateService->getByDateRange($start, $end) as $date => $tasks) {
            foreach ($tasks as $task) {
                $result[$date][] = $this->createResponseDtoService->create($task['task'], $task['forDate']);
            }
        }

        return $result;
    }

    /**
     * @throws \Exception
     *
     * @return TaskDto[]
     */
    public function getOverdueTasks(): array
    {
        $result = [];

        foreach ($this->getOverdueTasksService->get() as $task) {
            $result[] = $this->createResponseDtoService->create($task['task'], $task['forDate'], $task['date']);
        }

        return $result;
    }

    /**
     * @param string         $name
     * @param \DateTime      $startDate
     * @param \DateTime|null $endDate
     * @param string|null    $repeatType
     * @param array|null     $repeatValue
     * @param array|null     $schedule
     *
     * @return TaskDto
     */
    public function createTask(
        string $name,
        \DateTime $startDate,
        \DateTime $endDate = null,
        string $repeatType = null,
        array $repeatValue = null,
        array $schedule = null
    ): TaskDto {
        $task = $this->createTaskService->create($name, $startDate, $endDate, $repeatType, $repeatValue, $schedule);

        return $this->createResponseDtoService->create($task, $startDate);
    }

    /**
     * @param Task      $task
     * @param \DateTime $forDate
     * @param \DateTime $to
     *
     * @return TaskDto
     */
    public function transferTask(Task $task, \DateTime $forDate, \DateTime $to): TaskDto
    {
        $this->transferTaskService->transfer($task, $forDate, $to);

        return $this->createResponseDtoService->create($task, $task->getStartDate());
    }

    /**
     * @param Task      $task
     * @param \DateTime $forDate
     * @param string    $state
     *
     * @return TaskDto
     */
    public function updateTaskState(Task $task, \DateTime $forDate, string $state): TaskDto
    {
        $this->updateTaskStateService->update($task, $forDate, $state);

        $dto = $this->createResponseDtoService->create($task, $forDate);
        $dto->state = $state;

        return $dto;
    }

    /**
     * @param Task      $task
     * @param \DateTime $forDate
     * @param int       $position
     *
     * @return TaskDto
     */
    public function updateTaskPosition(Task $task, \DateTime $forDate, int $position): TaskDto
    {
        $this->updateTaskPositionService->update($task, $forDate, $position);

        $dto = $this->createResponseDtoService->create($task, $forDate);
        $dto->position = $position;

        return $dto;
    }
}
