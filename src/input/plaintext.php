<?php

namespace GOL\Input;

use GOL\Boards\Board;
use Ulrichsg\Getopt;

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
        $file = $_getopt->getOption("plaintextFile");
        if ($file == null)
        {
            echo "Option --plaintextFile must be set!\n";
            return;
        }
        $posY = 0;

        $fh = fopen($file, 'r');

        //read data
        while ($line = fgets($fh))
        {
            if (substr($line, 0, 1) == '!')
                continue;
            //for each char
            for ($i = 0; $i < strlen($line); $i++)
            {
                if ( substr($line, $i, 1) == 'O' )
                    $_board->setCell($i , $posY, 1);
            }

            $posY+= 1;
        }
        fclose($fh);
    }

    /**
     * Register all optional parameters of an Input, if any.
     * @param Getopt $_getopt Option manager to add the options
     */
    public function register(Getopt $_getopt): void
    {
        $_getopt->addOptions(
            [
                [null, "plaintextFile", Getopt::REQUIRED_ARGUMENT, "Pattern to load"]
            ]);
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