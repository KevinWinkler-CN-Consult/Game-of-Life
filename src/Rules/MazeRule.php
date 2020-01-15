<?php


namespace GOL\Rules;


use GOL\Boards\Field;

class MazeRule extends Rule
{
    public function apply(Field $_field): bool
    {
        $survive = [0, 1, 1, 1, 1, 1, 0, 0, 0];
        $born = [0, 0, 0, 1, 0, 0, 0, 0, 0];
        $numberOfLivingNeighbors = $_field->numberOfLivingNeighbors();

        return $_field->value() ? $survive[$numberOfLivingNeighbors] : $born[$numberOfLivingNeighbors];
    }
}