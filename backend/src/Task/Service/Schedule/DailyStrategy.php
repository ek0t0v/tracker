<?php

namespace Task\Service\Schedule;

/**
 * Class DailyStrategy.
 */
class DailyStrategy implements Strategy
{
    /**
     * {@inheritdoc}
     */
    public function isScheduled(\DateTime $date, \DateTime $start, array $schedule = null): bool
    {
        return true;
    }
}
