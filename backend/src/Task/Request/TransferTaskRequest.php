<?php

namespace Task\Request;

use Common\Http\RequestDtoInterface;
use Common\Validator\Constraints\NotPast;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TransferTaskRequest.
 */
class TransferTaskRequest implements RequestDtoInterface
{
    /**
     * @var \DateTime
     *
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Date
     * @NotPast
     */
    public $to;
}
