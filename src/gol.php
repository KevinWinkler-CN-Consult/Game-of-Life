<?php

use GetOpt\GetOpt;
use GOL\Boards\Board;
use GOL\GameLogic;
use GOL\Input\Input;
use GOL\Output\Output;
use GOL\Rules\Rule;
use GOL\Rules\StandardRule;

require_once "../vendor/autoload.php";

$maxIteration = 21;
$version = "1.2";
$width = 10;
$height = 10;
$historyLength = 2;

/**
 * @var Board $field
 * @var Input[] $inputs
 * @var Output $output
 * @var Output[] $outputs
 * @var Rule $rule
 * @var Rule[] $rules
 */
$field = null;
$inputs = [];
$output = null;
$outputs = [];
$rule = null;
$rules = [];

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
        [null, 'outputList', Getopt::NO_ARGUMENT, "Prints a list of all available output"],

        [null, 'rule', Getopt::REQUIRED_ARGUMENT, "Specifies the rule"],
        [null, 'ruleList', Getopt::NO_ARGUMENT, "Prints a list of all available rules"]
    ]);

foreach ($files = glob("Input/*") as $file)
{
    $basename = basename($file, ".php");
    $classname = "\\GOL\\Input\\" . $basename;

    if ($basename == "Input")
        continue;

    if (class_exists($classname))
    {
        $inputs[$basename] = new $classname;
        $getOpt->addOptions(end($inputs)->register());
    }
}

foreach ($files = glob("Output/*") as $file)
{
    $basename = basename($file, ".php");
    $classname = "\\GOL\\Output\\" . $basename;

    if ($basename == "Output")
        continue;

    if (class_exists($classname))
    {
        $outputs[$basename] = new $classname;
        $getOpt->addOptions(end($outputs)->register());
    }
}

foreach ($files = glob("Rules/*") as $file)
{
    $basename = basename($file, ".php");
    $classname = "\\GOL\\Rules\\" . $basename;

    if ($basename == "Rule")
        continue;

    if (class_exists($classname))
    {
        $rules[$basename] = new $classname;
        $getOpt->addOptions(end($rules)->register());
    }
}

$getOpt->process();

if ($getOpt->getOption('h'))
{
    echo $getOpt->getHelpText();
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
    foreach ($outputs as $type => $out)
    {
        echo $type . " " . $out->description() . "\n";
    }
    die;
}
if($getOpt->getOption("ruleList"))
{
    echo "Available rules\n";
    foreach ($rules as $type => $out)
    {
        echo $type . " " . $out->description() . "\n";
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
            $output->checkParameters($getOpt);
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

    $field->setFieldValue(1, 0, 1);

    $field->setFieldValue(2, 1, 1);

    $field->setFieldValue(0, 2, 1);
    $field->setFieldValue(1, 2, 1);
    $field->setFieldValue(2, 2, 1);
}

if ($getOpt->getOption("rule"))
{
    $arg = $getOpt->getOption("rule");

    foreach ($rules as $type => $r)
    {
        if ($type == $arg)
        {
            $r->initialize($getOpt);
            $rule = $r;
            break;
        }
    }
}
else
{
    $rule = new StandardRule();
}

if ($output == null)
{
    echo "An output has to be defined!\n";
    die;
}

$logic = new GameLogic($field,$rule);

for ($i = 0; $i < $maxIteration; $i++)
{
    $output->write($field);
    $logic->nextGeneration($field);

    if ($logic->isLooping())
        break;
}

$output->flush();