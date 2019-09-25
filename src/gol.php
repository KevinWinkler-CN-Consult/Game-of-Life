<?php

use GOL\Boards\Board;
use GOL\Boards\BoardGlider;
use GOL\Boards\BoardRandom;
use GOL\Rule;

require_once "include.php";

$field = new BoardGlider(10,10);
$rule = new Rule([3], [2, 3]);
$maxIteration= 21;
$version = "1.0";

function nextGeneration(Board &$_board, Rule &$_rule)
{
    $buffer = $_board->grid();

    for ($y = 1; $y < $_board->height() - 1; $y++)
        for ($x = 1; $x < $_board->width() - 1; $x++)
            $buffer[$y][$x] = $_rule->applyRule($_board->getNeighbours($y, $x), $_board->grid()[$y][$x]);

    $_board->setGrid($buffer);
}

for ($i = 0; $i < $maxIteration; $i++)
{
    echo "Generation:$i\n";
    $field->printBoard();
    nextGeneration($field, $rule);
}