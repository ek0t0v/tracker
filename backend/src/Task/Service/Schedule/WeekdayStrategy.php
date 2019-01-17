<?php

namespace Task\Service\Schedule;

/**
 * Class WeekdayStrategy.
 */
class WeekdayStrategy implements Strategy
{
    /**
     * {@inheritdoc}
     */
    public function isScheduled(\DateTime $date, \DateTime $start, array $schedule = null): bool
    {
        $weekdayIndex = $date->format('w');

        return !in_array($weekdayIndex, [0, 6]);
    }
}
