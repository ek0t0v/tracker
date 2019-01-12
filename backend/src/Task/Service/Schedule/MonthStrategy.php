<?php

namespace Task\Service\Schedule;

/**
 * Class MonthStrategy.
 */
class MonthStrategy implements Strategy
{
    /**
     * {@inheritdoc}
     */
    public function isScheduled(\DateTime $date, \DateTime $start, array $schedule = null): bool
    {
        return false;
    }
}
