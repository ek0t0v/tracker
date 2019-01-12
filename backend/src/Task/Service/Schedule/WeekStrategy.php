<?php

namespace Task\Service\Schedule;

/**
 * Class WeekStrategy.
 */
class WeekStrategy implements Strategy
{
    /**
     * {@inheritdoc}
     */
    public function isScheduled(\DateTime $date, \DateTime $start, array $schedule = null): bool
    {
        $weekdayIndex = $date->format('w');

        return 1 === $schedule[$weekdayIndex];
    }
}
