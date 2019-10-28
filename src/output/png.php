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
            imagecolorallocate($image, 0, 0, 0);
            $white = imagecolorallocate($image, 255, 255, 255);

            for ($y = 0; $y < $height; $y++)
            {
                for ($x = 0; $x < $with; $x++)
                {
                    if ($board[$x][$y] == 1)
                        imagesetpixel($image, $x, $y, $white);
                }
            }

            imagepng($image, "out/" . sprintf("img-%03d", $index) . ".png");
        }
        $this->buffer = [];
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