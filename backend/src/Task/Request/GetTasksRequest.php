<?php

namespace Task\Request;

use Common\Http\RequestDtoInterface;
use Common\Validator\Constraints\NotBlankIfNotNull;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class GetTasksRequest.
 */
class GetTasksRequest implements RequestDtoInterface
{
    /**
     * @var \DateTime
     *
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Date
     */
    public $start;

    /**
     * @var \DateTime|null
     *
     * @NotBlankIfNotNull
     * @Assert\Date
     */
    public $end;
}
