<?php

namespace App\Service\Task;

use App\Dto\ApiResponse\TaskDto;
use App\Entity\Task;

/**
 * Class TaskFacade.
 */
class TaskFacade
{
    /**
     * @var DtoService
     */
    private $dtoService;

    /**
     * @var GetByDateService
     */
    private $getByDateService;

    /**
     * @var GetOverdueService
     */
    private $getOverdueService;

    /**
     * @var CreateTaskService
     */
    private $createTaskService;

    /**
     * @var ChangeService
     */
    private $changeService;

    /**
     * TaskFacade constructor.
     *
     * @param DtoService        $dtoService
     * @param GetByDateService  $getByDateService
     * @param GetOverdueService $getOverdueService
     * @param CreateTaskService $createTaskService
     * @param ChangeService     $changeService
     */
    public function __construct(
        DtoService $dtoService,
        GetByDateService $getByDateService,
        GetOverdueService $getOverdueService,
        CreateTaskService $createTaskService,
        ChangeService $changeService
    ) {
        $this->dtoService = $dtoService;
        $this->getByDateService = $getByDateService;
        $this->getOverdueService = $getOverdueService;
        $this->createTaskService = $createTaskService;
        $this->changeService = $changeService;
    }

    /**
     * @param \DateTime $date
     *
     * @return TaskDto[]
     */
    public function getTasksByDate(\DateTime $date): array
    {
        $result = [];

        foreach ($this->getByDateService->getByDate($date) as $task) {
            $result[] = $this->dtoService->create($task);
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
    }

    /**
     * @return TaskDto[]
     */
    public function getOverdueTasks(): array
    {
        $result = [];

        foreach ($this->getOverdueService->get() as $task) {
            $result[] = $this->dtoService->create($task['task'], $task['forDate'], $task['date']);
        }

        return $result;
    }

    /**
     * @param string         $name
     * @param \DateTime      $startDate
     * @param \DateTime|null $endDate
     * @param array|null     $schedule
     *
     * @return TaskDto
     */
    public function createTask(string $name, \DateTime $startDate, \DateTime $endDate = null, array $schedule = null): TaskDto
    {
        $task = $this->createTaskService->create($name, $startDate, $endDate, $schedule);

        return $this->dtoService->create($task, $startDate);
    }

    /**
     * @todo Сделать ограничения на перемещение задач, например, нельзя перемещать готовые/отмененные задачи.
     *
     * @param Task      $task
     * @param \DateTime $forDate
     * @param \DateTime $to
     *
     * @return TaskDto
     */
    public function transferTask(Task $task, \DateTime $forDate, \DateTime $to): TaskDto
    {
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
        $this->changeService->updateState($task, $forDate, $state);

        $dto = $this->dtoService->create($task, $forDate);
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
        $this->changeService->updatePosition($task, $forDate, $position);

        $dto = $this->dtoService->create($task, $forDate);
        $dto->position = $position;

        return $dto;
    }
}
