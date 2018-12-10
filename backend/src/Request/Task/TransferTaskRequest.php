<?php

namespace App\Request\Task;

use App\Http\RequestDtoInterface;
use App\Validator\Constraints\NotPast;
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
     */
    public $forDate;

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
