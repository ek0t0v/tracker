<?php

namespace App\Service\Schedule;

/**
 * Interface Strategy.
 */
interface Strategy
{
    /**
     * @param \DateTime $date
     * @param null      $schedule
     *
     * @return bool
     */
    public function isScheduled(\DateTime $date, $schedule = null): bool;
}
