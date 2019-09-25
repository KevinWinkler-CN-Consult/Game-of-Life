<?php

use GOL\Boards\Board;
use GOL\Boards\BoardGlider;
use GOL\Boards\BoardRandom;
use GOL\Rule;
use Ulrichsg\Getopt;

require_once "include.php";
require_once "ulrichsg/getopt.php";

$maxIteration = 21;
$version = "1.0";
$width = 10;
$height = 10;

$field = null;
$rule = new Rule([3], [2, 3]);

$getOpt = new Getopt(
    [
        ['h', 'help', Getopt::NO_ARGUMENT, "Prints this page"],
        ['v', 'version', Getopt::NO_ARGUMENT, "Prints the version at program start"],

        [null, 'width', Getopt::REQUIRED_ARGUMENT, "Width of the board"],
        [null, 'height', Getopt::REQUIRED_ARGUMENT, "Height of the board"],
        ['m', 'maxIteration', Getopt::REQUIRED_ARGUMENT, "Maximum number of iteration"],
        [null, 'startRandom', Getopt::NO_ARGUMENT, "Start with random values"],
        [null, 'startGlider', Getopt::NO_ARGUMENT, "Start with a glider in the upper left corner"]
    ]);

$getOpt->parse();

if ($getOpt->getOption('h'))
{
    $getOpt->showHelp();
    die;
}
if ($getOpt->getOption('v'))
{
    echo "Game of Life algorithm in php.\n" .
        "Version $version \n";
    die;
}

if ($getOpt->getOption('width'))
{
    $width = intval($getOpt->getOption('width'));
    if ($width == 0)
        $width = 10;
}
if ($getOpt->getOption('height'))
{
    $height = intval($getOpt->getOption('height'));
    if ($height == 0)
        $height = 10;
}
if ($getOpt->getOption('m'))
{
    $maxIteration = intval($getOpt->getOption('m'));
}

if ($getOpt->getOption("startRandom"))
{
    $field = new BoardRandom($width, $height);
}
else if ($getOpt->getOption("startGlider"))
{
    $field = new BoardGlider($width, $height);
}
else
{
    $field = new BoardGlider($width, $height);
}

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