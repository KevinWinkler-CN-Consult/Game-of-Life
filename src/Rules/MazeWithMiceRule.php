<?php


namespace GOL\Rules;


use GOL\Boards\Field;

/**
 * This rule is like the maze rule with mice moving inside.
 * Use apply() to apply the rule on a field.
 */
class MazeWithMiceRule extends Rule
{
    /**
     * @param Field $_field Cell to check.
     * @return bool cells state in the next generation.
     */
    public function apply(Field $_field): bool
    {
        $survive = [0, 1, 1, 1, 1, 1, 0, 0, 0];
        $born = [0, 0, 0, 1, 0, 0, 0, 1, 0];
        $numberOfLivingNeighbors = $_field->numberOfLivingNeighbors();

        return $_field->value() ? $survive[$numberOfLivingNeighbors] : $born[$numberOfLivingNeighbors];
    }
}