<?php

namespace App\Service\Schedule;

use App\Doctrine\DBAL\Type\TaskRepeatTypeType;

/**
 * Class Context.
 *
 * По поводу стратегий weekday (будние дни) и weekend (выходные) - эти дни могут
 * быть разными, т.е. определяться пользовательскими настройками. В будущем
 * можно добавить аргумент payload в стратегиях для передачи специальных данных.
 */
class Context
{
    /**
     * @var Strategy
     */
    private $strategy;

    /**
     * Устанавливает контекст на основе repeatType задачи. Можно реализовать и
     * другие setContext-методы.
     *
     * @param string $taskRepeatType
     */
    public function setContextByTaskRepeatType(string $taskRepeatType)
    {
        switch ($taskRepeatType) {
            case TaskRepeatTypeType::DAILY:
                $this->strategy = new DailyStrategy();

                break;
            case TaskRepeatTypeType::WEEK:
                $this->strategy = new WeekStrategy();

                break;
            case TaskRepeatTypeType::MONTH:
                $this->strategy = new MonthStrategy();

                break;
            case TaskRepeatTypeType::WEEKDAY:
                $this->strategy = new WeekdayStrategy();

                break;
            case TaskRepeatTypeType::WEEKEND:
                $this->strategy = new WeekendStrategy();

                break;
            case TaskRepeatTypeType::CUSTOM:
                $this->strategy = new CustomStrategy();

                break;
        }
    }

    /**
     * Не учитывает часовые пояса - какую дату передали, по такой и определяет.
     *
     * @param \DateTime  $date
     * @param \DateTime  $start
     * @param array|null $schedule
     *
     * @return bool
     */
    public function isScheduled(\DateTime $date, \DateTime $start, array $schedule = null): bool
    {
        return $this->strategy->isScheduled($date, $start, $schedule);
    }
}
