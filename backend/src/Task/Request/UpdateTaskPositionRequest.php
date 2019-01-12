<?php

namespace Task\Request;

use Common\Http\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UpdateTaskPositionRequest.
 */
class UpdateTaskPositionRequest implements RequestDtoInterface
{
    /**
     * @var int
     *
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Type("integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    public $position;
}
