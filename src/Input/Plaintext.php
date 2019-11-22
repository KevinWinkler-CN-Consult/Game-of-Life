<?php

namespace GOL\Input;

use GetOpt\Getopt;
use GetOpt\Option;
use GOL\Boards\Board;

/**
 * Fills the board with a specific pattern saved in the plaintext(.cells) format.
 *
 * Plaintext stores the state of a cell as an Ascii character
 * . = dead
 * O = alive
 * Lines that start with ! are treated as comment.
 * Any other line represents a row of the pattern.
 *
 * Example of a glider:
 * !Name: Glider
 * !
 * .O.
 * ..O
 * OOO
 *
 * Use prepareBoard() to prepare a Board and register()
 * to register optional arguments.
 */
class Plaintext extends Input
{
    /**
     * Prepares a Board for usage.
     * @param Board $_board Board to prepare.
     * @param Getopt $_getopt Option manager to check for optional arguments.
     */
    public function prepareBoard(Board &$_board, Getopt $_getopt): void
    {
        $filePath = $_getopt->getOption("plaintextFile");
        if ($filePath == null)
        {
            echo "Option --plaintextFile must be set!\n";
            return;
        }
        $posY = 0;

        $fileHandle = fopen($filePath, 'r');

        //read data
        while ($line = fgets($fileHandle))
        {
            if (substr($line, 0, 1) == '!')
                continue;
            //for each char
            for ($i = 0; $i < strlen($line); $i++)
            {
                if (substr($line, $i, 1) == 'O')
                    $_board->setCell($i, $posY, 1);
            }

            $posY += 1;
        }
        fclose($fileHandle);
    }

    /**
     * Register all optional parameters of an Input, if any.
     * @return array Array of options.
     */
    public function register(): array
    {
        $result[] = new Option(null, "plaintextFile", Getopt::REQUIRED_ARGUMENT);
        end($result)->setDescription("Pattern to load");

        return $result;
    }

    /**
     * Returns the description of the Input.
     * @return string description.
     */
    public function description(): string
    {
        return "creates a board from plaintext";
    }
}