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
     * @var CreateService
     */
    private $createService;

    /**
     * @var StateService
     */
    private $stateService;

    /**
     * @var PositionService
     */
    private $positionService;

    /**
     * @var TransferService
     */
    private $transferService;

    /**
     * TaskFacade constructor.
     *
     * @param DtoService        $dtoService
     * @param GetByDateService  $getByDateService
     * @param GetOverdueService $getOverdueService
     * @param CreateService     $createService
     * @param StateService      $stateService
     * @param PositionService   $positionService
     * @param TransferService   $transferService
     */
    public function __construct(
        DtoService $dtoService,
        GetByDateService $getByDateService,
        GetOverdueService $getOverdueService,
        CreateService $createService,
        StateService $stateService,
        PositionService $positionService,
        TransferService $transferService
    ) {
        $this->dtoService = $dtoService;
        $this->getByDateService = $getByDateService;
        $this->getOverdueService = $getOverdueService;
        $this->createService = $createService;
        $this->stateService = $stateService;
        $this->positionService = $positionService;
        $this->transferService = $transferService;
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
            $result[] = $this->dtoService->create($task['task'], $task['forDate']);
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

        foreach ($this->getByDateService->getByDateRange($start, $end) as $date => $tasks) {
            foreach ($tasks as $task) {
                $result[$date][] = $this->dtoService->create($task['task'], $task['forDate']);
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

        foreach ($this->getOverdueService->get() as $task) {
            $result[] = $this->dtoService->create($task['task'], $task['forDate'], $task['date']);
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
        $task = $this->createService->create($name, $startDate, $endDate, $repeatType, $repeatValue, $schedule);

        return $this->dtoService->create($task, $startDate);
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
        $this->transferService->transfer($task, $forDate, $to);

        return $this->dtoService->create($task, $task->getStartDate());
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
        $this->stateService->update($task, $forDate, $state);

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
        $this->positionService->update($task, $forDate, $position);

        $dto = $this->dtoService->create($task, $forDate);
        $dto->position = $position;

        return $dto;
    }
}
