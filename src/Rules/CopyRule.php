<?php


namespace GOL\Rules;

use GOL\Boards\Field;

class CopyRule extends Rule
{
    public function apply(Field $_field): bool
    {
        $survive = [0, 1, 0, 1, 0, 1, 0, 1, 0];
        $born = [0, 1, 0, 1, 0, 1, 0, 1, 0];
        $numberOfLivingNeighbors = $_field->numberOfLivingNeighbors();

        return $_field->value() ? $survive[$numberOfLivingNeighbors] : $born[$numberOfLivingNeighbors];
    }
}