<?php

namespace App\Service\Schedule;

/**
 * Class DailyStrategy.
 */
class DailyStrategy implements Strategy
{
    /**
     * {@inheritdoc}
     */
    public function isScheduled(\DateTime $date, $schedule = null): bool
    {
        return true;
    }
}
