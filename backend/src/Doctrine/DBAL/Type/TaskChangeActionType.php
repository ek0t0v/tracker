<?php

namespace App\Doctrine\DBAL\Type;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class TaskChangeActionType.
 */
final class TaskChangeActionType extends AbstractEnumType
{
    public const RENAME = 'rename';
    public const UPDATE_STATE = 'update_state';
    public const UPDATE_POSITION = 'update_position';
    public const TRANSFER_FROM = 'transfer_from';
    public const TRANSFER_TO = 'transfer_to';

    protected static $choices = [
        self::RENAME => 'rename',
        self::UPDATE_STATE => 'update_state',
        self::UPDATE_POSITION => 'update_position',
        self::TRANSFER_FROM => 'transfer_from',
        self::TRANSFER_TO => 'transfer_to',
    ];
}
