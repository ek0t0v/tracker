<?php

namespace Task\Service\Schedule;

/**
 * Interface Strategy.
 */
interface Strategy
{
    /**
     * @param \DateTime  $date
     * @param \DateTime  $start
     * @param array|null $schedule
     *
     * @return bool
     */
    public function isScheduled(\DateTime $date, \DateTime $start, array $schedule = null): bool;
}
