<?php

namespace Task\Request;

use Common\Http\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AddTimingRequest.
 */
class AddTimingRequest implements RequestDtoInterface
{
    /**
     * @var int
     *
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\GreaterThan(0)
     */
    public $taskId;

    /**
     * @var int
     *
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\GreaterThan(0)
     */
    public $startedAt;

    /**
     * @var int
     *
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\GreaterThan(0)
     */
    public $endedAt;
}
