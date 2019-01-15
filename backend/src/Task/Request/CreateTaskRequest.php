<?php

namespace Task\Request;

use Common\Http\RequestDtoInterface;
use Common\Validator\Constraints\NotBlankIfNotNull;
use Task\Validator\Constraint\TaskRepeatValue;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreateTaskRequest.
 *
 * @Assert\Callback({"Task\Validator\TaskEndValidator", "validate"})
 */
class CreateTaskRequest implements RequestDtoInterface
{
    /**
     * @var string
     *
     * @Assert\NotNull
     * @Assert\Type("string")
     * @Assert\Length(
     *     min="1"
     * )
     */
    public $name;

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

    /**
     * @var string|null
     *
     * @NotBlankIfNotNull
     * @Assert\Choice(callback={"Task\Doctrine\DBAL\Type\TaskRepeatTypeType", "getChoices"})
     */
    public $repeatType;

    /**
     * @var array|null
     *
     * @Assert\Type("array")
     * @TaskRepeatValue
     */
    public $repeatValue;
}
