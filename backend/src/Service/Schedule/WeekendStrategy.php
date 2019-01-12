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

        return in_array($weekdayIndex, [0, 6]);
    }
}
