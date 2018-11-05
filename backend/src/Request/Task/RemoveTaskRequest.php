<?php

namespace App\Request\Task;

use App\Http\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RemoveTaskRequest.
 */
class RemoveTaskRequest implements RequestDtoInterface
{
    /**
     * @var int[]
     *
     * @Assert\NotNull()
     * @Assert\All({
     *     @Assert\NotNull(),
     *     @Assert\GreaterThan(0)
     * })
     */
    public $ids;
}
