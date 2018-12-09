<?php

namespace App\Request\Task;

use App\Http\RequestDtoInterface;
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
     * @Assert\NotEqualTo(
     *     propertyPath="forDate",
     *     message="This value should not be equal to forDate."
     * )
     */
    public $to;
}
