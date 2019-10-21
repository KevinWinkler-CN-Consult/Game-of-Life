<?php

use GOL\Boards\Board;
use GOL\Boards\history;
use GOL\Input\Input;
use GOL\Output\Output;
use Ulrichsg\Getopt;

require_once "include.php";
require_once "ulrichsg/getopt.php";

$maxIteration = 21;
$version = "1.2";
$width = 10;
$height = 10;

$field = null;
$output = null;
/** @var Input */
$inputs = [];
/** @var Output $outputs */
$outputs = [];

$getOpt = new Getopt(
    [
        ['h', 'help', Getopt::NO_ARGUMENT, "Prints this page"],
        ['v', 'version', Getopt::NO_ARGUMENT, "Prints the version"],

        [null, 'width', Getopt::REQUIRED_ARGUMENT, "Width of the board"],
        [null, 'height', Getopt::REQUIRED_ARGUMENT, "Height of the board"],
        ['m', 'maxIterations', Getopt::REQUIRED_ARGUMENT, "Maximum number of iterations"],

        [null, 'input', Getopt::REQUIRED_ARGUMENT, "Specifies the input"],
        [null, 'inputList', Getopt::NO_ARGUMENT, "Prints a list of all available inputs"],

        [null, 'output', Getopt::REQUIRED_ARGUMENT, "Specifies the output"],
        [null, 'outputList', Getopt::NO_ARGUMENT, "Prints a list of all available output"]
    ]);

foreach ($files = glob("input/*") as $file)
{
    $basename = basename($file, ".php");
    $classname = "\\GOL\\Input\\" . $basename;

    if ($basename == "input")
        continue;

    if (class_exists($classname))
    {
        $inputs[$basename] = new $classname;
        end($inputs)->register($getOpt);
    }
}

foreach ($files = glob("output/*") as $file)
{
    $basename = basename($file, ".php");
    $classname = "\\GOL\\Output\\" . $basename;

    if ($basename == "output")
        continue;

    if (class_exists($classname))
    {
        $outputs[$basename] = new $classname;
        end($outputs)->register($getOpt);
    }
}

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
if ($getOpt->getOption("inputList"))
{
    echo "Available inputs\n";
    foreach ($inputs as $type => $input)
    {
        echo $type . " " . $input->description() . "\n";
    }
    die;
}
if ($getOpt->getOption("outputList"))
{
    echo "Available outputs\n";
    foreach ($outputs as $type => $output)
    {
        echo $type . " " . $output->description() . "\n";
    }
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

if ($getOpt->getOption("output"))
{
    $arg = $getOpt->getOption("output");

    foreach ($outputs as $type => $out)
    {
        if ($type == $arg)
        {
            $output = $out;
            $output->checkParamerters($getOpt);
            break;
        }
    }
}

if ($getOpt->getOption("input"))
{
    $arg = $getOpt->getOption("input");

    foreach ($inputs as $type => $input)
    {
        if ($type == $arg)
        {
            $field = new Board($width, $height);
            $input->prepareBoard($field, $getOpt);
            break;
        }
    }
}

if ($field == null)
{
    $field = new Board($width, $height);

    $field->setCell(1, 0, 1);

    $field->setCell(2, 1, 1);

    $field->setCell(0, 2, 1);
    $field->setCell(1, 2, 1);
    $field->setCell(2, 2, 1);
}

if ( $output == null )
{
    echo "An output has to be defined!\n";
    die;
}

$history = new history($field);

for ($i = 0; $i < $maxIteration; $i++)
{
    $output->write($field);
    $field->nextGeneration();

    if ($history->stackSize() > 2)
        $history->pop();

    if ($history->compare($field))
        break;

    $history->push($field);
}

$output->flush();