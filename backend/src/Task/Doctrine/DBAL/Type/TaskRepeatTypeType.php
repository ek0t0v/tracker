<?php

namespace Task\Doctrine\DBAL\Type;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class TaskRepeatTypeType.
 */
final class TaskRepeatTypeType extends AbstractEnumType
{
    public const DAILY = 'daily';
    public const WEEK = 'week';
    public const MONTH = 'month';
    public const WEEKDAY = 'weekday';
    public const WEEKEND = 'weekend';
    public const CUSTOM = 'custom';

    /**
     * @var array
     */
    protected static $choices = [
        self::DAILY => 'daily',
        self::WEEK => 'week',
        self::MONTH => 'month',
        self::WEEKDAY => 'weekday',
        self::WEEKEND => 'weekend',
        self::CUSTOM => 'custom',
    ];
}
