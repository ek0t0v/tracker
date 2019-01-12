<?php

namespace Task\Service\Schedule;

/**
 * Class CustomStrategy.
 */
class CustomStrategy implements Strategy
{
    /**
     * {@inheritdoc}
     */
    public function isScheduled(\DateTime $date, \DateTime $start, array $schedule = null): bool
    {
        $daysDiff = $date->diff($start)->days;
        $scheduleArraySize = count($schedule);

        if (0 === $daysDiff) {
            $i = 0;
        } elseif ($daysDiff < $scheduleArraySize) {
            $i = $daysDiff;
        } else {
            $i = $daysDiff % $scheduleArraySize;
        }

        return 1 === $schedule[$i];
    }
}
