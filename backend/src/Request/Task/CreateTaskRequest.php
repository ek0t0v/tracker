<?php

namespace App\Request\Task;

use App\Http\RequestDtoInterface;
use App\Validator\Constraints\NotBlankIfNotNull;
use App\Validator\Constraints\TaskRepeatValue;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * todo: Доработать валидацию.
 *
 * - start всегда должен быть меньше end
 * - repeatValue при типе повторения custom не должен быть [0,0], надо хотя бы [1,0], например
 * - не допускать пустое имя задачи, нужно хотя бы один символ
 *
 * Class CreateTaskRequest.
 */
class CreateTaskRequest implements RequestDtoInterface
{
    /**
     * @var string
     *
     * @Assert\NotNull
     * @Assert\Type("string")
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
     * @Assert\Choice(callback={"App\Doctrine\DBAL\Type\TaskRepeatTypeType", "getChoices"})
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
