<?php

namespace GOL\Output;

use GOL\Boards\Board;
use Ulrichsg\Getopt;

/**
 * Saves the Board as a png sequence.
 *
 * Use write() to write the Board data to the output.
 * and flush() to write it on the disc.
 */
class PNG extends Output
{
    private $buffer = [];
    private $backgroundColor = [];
    private $cellColor = [];

    /**
     * Writes the current board to the Output.
     *
     * @param Board $_board Board to output.
     */
    public function write(Board $_board): void
    {
        $this->buffer[] = $_board->getGrid();
    }

    /**
     * Writes the data to the console.
     */
    public function flush(): void
    {
        if (!is_dir("out/"))
            mkdir("out/", 0755);

        foreach ($this->buffer as $index => $board)
        {
            $with = count($board);
            $height = count($board[0]);

            $image = imagecreate($with, $height);
            imagecolorallocate($image, $this->backgroundColor[0], $this->backgroundColor[1], $this->backgroundColor[2]);
            $cellColor = imagecolorallocate($image, $this->cellColor[0], $this->cellColor[1], $this->cellColor[2]);

            for ($y = 0; $y < $height; $y++)
            {
                for ($x = 0; $x < $with; $x++)
                {
                    if ($board[$x][$y] == 1)
                        imagesetpixel($image, $x, $y, $cellColor);
                }
            }

            imagepng($image, "out/" . sprintf("img-%03d", $index) . ".png");
        }
        $this->buffer = [];
    }

    /**
     * Checks for optional parameters.
     * @param Getopt $_getopt Option manager to check for optional parameters.
     */
    public function checkParamerters(Getopt $_getopt): void
    {
        $seasonalColor = getHolidayColor();
        if (count($seasonalColor) == 6)
        {
            $this->backgroundColor[0] = $seasonalColor[0];
            $this->backgroundColor[1] = $seasonalColor[1];
            $this->backgroundColor[2] = $seasonalColor[2];
            $this->cellColor[0] = $seasonalColor[3];
            $this->cellColor[1] = $seasonalColor[4];
            $this->cellColor[2] = $seasonalColor[5];
        }
        else
        {
            $this->backgroundColor[0] = 0;
            $this->backgroundColor[1] = 0;
            $this->backgroundColor[2] = 0;
            $this->cellColor[0] = 255;
            $this->cellColor[1] = 255;
            $this->cellColor[2] = 255;
        }
    }

    /**
     * Returns the description of the Output.
     * @return string description.
     */
    public function description(): string
    {
        return "Outputs the Board as a png sequence.";
    }
}