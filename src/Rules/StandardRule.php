<?php

namespace GOL\Rules;

use GOL\Boards\Field;

/**
 * The standard rule of game of life.
 * Use apply() to apply the rule on a field.
 */
class StandardRule extends Rule
{
    /**
     * @param Field $_field Cell to check.
     * @return bool cells state in the next generation.
     */
    public function apply(Field $_field): bool
    {
        $survive = [0, 0, 1, 1, 0, 0, 0, 0, 0];
        $born = [0, 0, 0, 1, 0, 0, 0, 0, 0];
        $numberOfLivingNeighbors = $_field->numberOfLivingNeighbors();

        return $_field->value() ? $survive[$numberOfLivingNeighbors] : $born[$numberOfLivingNeighbors];
    }

    /**
     * Returns the description of the Rule.
     * This is used to list all rules if the argument ruleList is set.
     * @return string description.
     */
    public function description(): string
    {
        return "The standard rule of game of life.";
    }
}