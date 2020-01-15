<?php


namespace GOL\Rules;


use GOL\Boards\Field;

class MazeRule extends Rule
{
    public function apply(Field $field): bool
    {
        $survive = [0, 1, 1, 1, 1, 1, 0, 0, 0];
        $born = [0, 0, 0, 1, 0, 0, 0, 0, 0];
        $numberOfLivingNeighbors = $field->numberOfLivingNeighbors();

        return $field->value() ? $survive[$numberOfLivingNeighbors] : $born[$numberOfLivingNeighbors];
    }
}