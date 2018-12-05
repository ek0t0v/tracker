<?php

namespace App\Doctrine\DBAL\Type;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class TaskChangeStateType.
 */
final class TaskChangeStateType extends AbstractEnumType
{
    public const IN_PROGRESS = 'in_progress';
    public const DONE = 'done';
    public const CANCELLED = 'cancelled';

    /**
     * @var array
     */
    protected static $choices = [
        self::IN_PROGRESS => 'in_progress',
        self::DONE => 'done',
        self::CANCELLED => 'cancelled',
    ];
}
