<?php

namespace App\Service\Schedule;

/**
 * Class WeekendStrategy.
 */
class WeekendStrategy implements Strategy
{
    /**
     * {@inheritdoc}
     */
    public function isScheduled(\DateTime $date, \DateTime $start, array $schedule = null): bool
    {
        $weekdayIndex = $date->format('w');

        return 0 === $weekdayIndex || 6 === $weekdayIndex;
    }
}
