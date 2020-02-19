<?php

namespace GOL\Input;

use GetOpt\Getopt;
use GetOpt\Option;
use GOL\Boards\Board;

/**
 * Fills the board with a specific pattern saved in the Run Length Encoded(.rle) format.
 *
 * The RLE format consists of optional comment lines, a header line and the data.
 *
 * Any lines before the header line starting with # are considered comments.
 *
 * The header line has the form: x = m, y = n
 * where m and n are the with and the height of the pattern.
 *
 * The line after the header contains the pattern data.
 * The data is an encoded sequence of items in the form <run_count><tag>
 * where <run_count> is the number of occurrences of <tag> and <tag> is one of the following three characters:
 * b = dead cell
 * o = alive cell
 * $ = end of line
 * <run_count> can be omitted if it is equal to 1.
 *
 * An ! marks the end of the pattern.
 *
 * Carriage returns or line feeds should not be placed between <run_count> and <tag>.
 *
 * Example of a glider:
 * #C This is a glider.
 * x = 3, y = 3
 * bo$2bo$3o!
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
        $filePath = $_getopt->getOption("rleFile");

        if ($filePath == null)
        {
            echo "Option --rleFile must be set!\n";
            return;
        }

        $fileHandle = fopen($filePath, 'r');

        list($sizeX, $sizeY) = $this->readHeader($fileHandle);

        if ($_getopt->getOption("rlePosition"))
        {
            $arg = explode(',', $_getopt->getOption("rlePosition"));
            $offsetX = intval($arg[0]);
            $offsetY = intval($arg[1]);
        }
        else
        {
            $offsetX = floor($_board->width() / 2 - $sizeX / 2.0);
            $offsetY = floor($_board->height() / 2 - $sizeY / 2.0);
        }

        if ($offsetX + $sizeX <= $_board->width() || $offsetY + $sizeY <= $_board->height())
            echo "Pattern to big or offset to high. Pattern might be cropped.";
        if ($offsetX <= 0 || $offsetY <= 0)
            echo "Negative offset! Pattern might be cropped.";

        //read data
        $posX = 0;
        $posY = 0;
        $buffer = "";
        while ($char = fgetc($fileHandle))
        {
            if (is_numeric($char))
            {
                $buffer .= $char;
                continue;
            }

            $runCount = intval($buffer, 10) != 0 ? intval($buffer, 10) : 1;

            switch ($char)
            {
                case 'o':
                    for ($x = $posX; $x < ($posX + $runCount); $x++)
                        $_board->setFieldValue($x + $offsetX, $posY + $offsetY, 1);
                    $posX += $runCount;
                    break;
                case 'b':
                    $posX += $runCount;
                    break;
                case '$':
                    $posX = 0;
                    $posY += $runCount;
                    break;
            }
            $buffer = "";

            if ($char == '!')
                break;
        }
        fclose($fileHandle);
    }

    /**
     * Register all optional parameters of an Input, if any.
     * @return Option[] Array of options.
     */
    public function register(): array
    {
        $result[] = new Option(null, "rleFile", Getopt::REQUIRED_ARGUMENT);
        end($result)->setDescription("Pattern to load");

        $result[] = new Option(null, "rlePosition", Getopt::REQUIRED_ARGUMENT);
        end($result)->setDescription("Sets the position of the pattern \"x,y\"");

        return $result;
    }

    /**
     * Returns the description of the Input.
     * @return string description.
     */
    public function description(): string
    {
        return "creates a board with a specific RLE pattern";
    }

    /**
     * Reads the header of the RLE file and returns the size of the pattern.
     * @param $fileHandle resource opened RLE file.
     * @return array [size x,size y].
     */
    private function readHeader($fileHandle): array
    {
        $sizeX = 0;
        $sizeY = 0;
        while ($line = fgets($fileHandle))
        {
            if (substr($line, 0, 1) == '#')
                continue;

            $temp = trim($line);
            $content = explode(',', $temp);

            $sizeX = explode('=', $content[0])[1];
            $sizeY = explode('=', $content[1])[1];

            break;
        }
        return array($sizeX, $sizeY);
    }
}