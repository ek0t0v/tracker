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
    public function isScheduled(\DateTime $date, $schedule = null): bool
    {
        // TODO: Implement isScheduled() method.
    }
}
