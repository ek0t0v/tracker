<?php

namespace App\Service\Schedule;

/**
 * Class CustomStrategy.
 */
class CustomStrategy implements Strategy
{
    /**
     * {@inheritdoc}
     */
    public function isScheduled(\DateTime $date, $schedule = null): bool
    {
        // TODO: Implement isScheduled() method.
    }
}
