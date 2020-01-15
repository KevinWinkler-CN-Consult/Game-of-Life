<?php


namespace GOL\Rules;

use GOL\Boards\Field;

class CopyRule extends Rule
{
    public function apply(Field $field): bool
    {
        $survive = [0, 1, 0, 1, 0, 1, 0, 1, 0];
        $born = [0, 1, 0, 1, 0, 1, 0, 1, 0];
        $numberOfLivingNeighbors = $field->numberOfLivingNeighbors();

        return $field->value() ? $survive[$numberOfLivingNeighbors] : $born[$numberOfLivingNeighbors];
    }
}