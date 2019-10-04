<?php

namespace GOL\Input;

use GOL\Boards\Board;
use Ulrichsg\Getopt;

/**
 * Fills the board with a specific patter saved in the RLE format.
 *
 * Use prepareBoard() to prepare a Board and register()
 * to register optional arguments.
 */
class RLE extends Input
{
    /**
     * Prepares a Board for usage.
     * @param Board $_board Board to prepare.
     * @param Getopt $_getopt Option manager to check for optional arguments.
     */
    public function prepareBoard(Board &$_board, Getopt $_getopt): void
    {
        $file = $_getopt->getOption("rleFile");
        if ($file == null)
        {
            echo "Option --rleFile must be set!\n";
            return;
        }
        $sizeX = 0;
        $sizeY = 0;
        $posX = 0;
        $posY = 0;

        $fh = fopen($file, 'r');

        //read header
        while ($line = fgets($fh))
        {
            if (substr($line, 0, 1) == '#')
                continue;

            $temp = trim($line);
            $content = explode(',', $temp);

            $sizeX = explode('=', $content[0])[1];
            $sizeY = explode('=', $content[1])[1];

            break;
        }

        if ($sizeX > $_board->width() || $sizeY > $_board->height())
            echo "pattern to big for given field!";

        $offsetX = floor($_board->width() / 2 - $sizeX / 2.0);
        $offsetY = floor($_board->height() / 2 - $sizeY / 2.0);

        if ($_getopt->getOption("rlePosition"))
        {
            $arg = explode(',', $_getopt->getOption("rlePosition"));
            $offsetX = intval($arg[0]);
            $offsetY = intval($arg[1]);
        }

        //read data
        while ($line = fgets($fh))
        {
            $numberStart = -1;

            //for each char
            for ($i = 0; $i < strlen($line); $i++)
            {
                $char = substr($line, $i, 1);

                if (is_numeric($char))
                {
                    if ($numberStart == -1)
                        $numberStart = $i;
                    continue;
                }

                $runCount = 1;
                if ($numberStart != -1)
                    $runCount = intval(substr($line, $numberStart, $i + 1 - $numberStart));

                switch ($char)
                {
                    case '!':
                        return;
                    case '$':
                        $posX = 0;
                        $posY += $runCount;
                        break;
                    case 'o':
                        for ($x = $posX; $x < ($posX + $runCount); $x++)
                            $_board->setCell($x + $offsetX, $posY + $offsetY, 1);

                        $posX += $runCount;
                        break;
                    case 'b':
                        $posX += $runCount;
                }
                $numberStart = -1;

            }
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
                [null, "rleFile", Getopt::REQUIRED_ARGUMENT, "Pattern to load"],
                [null, "rlePosition", Getopt::REQUIRED_ARGUMENT, "Sets the position of the pattern \"x,y\""]
            ]);
    }

    /**
     * Returns the description of the Input.
     * @return string description.
     */
    public function description(): string
    {
        return "creates a board with a specific RLE pattern";
    }
}