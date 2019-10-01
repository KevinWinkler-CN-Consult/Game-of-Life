<?php

use GOL\Boards\Board;
use GOL\Boards\BoardAcorn;
use GOL\Boards\BoardGlider;
use GOL\Boards\BoardRandom;
use GOL\Boards\history;
use Ulrichsg\Getopt;

require_once "include.php";
require_once "ulrichsg/getopt.php";

$maxIteration = 21;
$version = "1.1";
$width = 10;
$height = 10;

$field = null;

$getOpt = new Getopt(
    [
        ['h', 'help', Getopt::NO_ARGUMENT, "Prints this page"],
        ['v', 'version', Getopt::NO_ARGUMENT, "Prints the version"],

        [null, 'width', Getopt::REQUIRED_ARGUMENT, "Width of the board"],
        [null, 'height', Getopt::REQUIRED_ARGUMENT, "Height of the board"],
        ['m', 'maxIteration', Getopt::REQUIRED_ARGUMENT, "Maximum number of iterations"],
        [null, 'startRandom', Getopt::NO_ARGUMENT, "Start with random values"],
        [null, 'startGlider', Getopt::NO_ARGUMENT, "Start with a glider in the upper left corner"],
        [null, 'startAcorn', Getopt::NO_ARGUMENT, "Start with an acorn in the center"]
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
    if ($width < 10)
        $width = 10;
}
if ($getOpt->getOption('height'))
{
    $height = intval($getOpt->getOption('height'));
    if ($height < 10)
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
else if ($getOpt->getOption("startAcorn"))
{
    $field = new BoardAcorn($width, $height);
}
else
{
    $field = new BoardAcorn($width, $height);
}

$history = new history($field);

for ($i = 0; $i < $maxIteration; $i++)
{
    echo "Generation:$i\n";
    $field->printBoard();
    $field->nextGeneration();

    if ($history->stackSize() > 2)
        $history->pop();

    if ($history->compare($field))
        break;

    $history->push($field);
}