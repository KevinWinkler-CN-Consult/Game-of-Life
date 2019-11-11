<?php

namespace GOL\Output;

use GifCreator\AnimGif;
use GOL\Boards\Board;
use Ulrichsg\Getopt;

require_once "animgif/AnimGif.php";

/**
 * Saves the board as a gif.
 *
 * Use write() to write the Board data to the buffer.
 * and flush() to write it on the disk.
 */
class Gif extends Output
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
     * Creates a gif.
     */
    public function flush(): void
    {
        $frames = [];

        if (!is_dir("out/"))
        {
            mkdir("out/", 0755);
        }

        foreach ($this->buffer as $index => $board)
        {
            $width = count($board);
            $height = count($board[0]);

            $image = imagecreate($width, $height);
            $backgroundColor = imagecolorallocate($image, 0, 0, 0);
            $cellColor = imagecolorallocate($image, 255, 255, 255);

            for ($y = 0; $y < $height; $y++)
            {
                for ($x = 0; $x < $width; $x++)
                {
                    imagesetpixel($image, $x, $y, $board[$x][$y] ? $cellColor : $backgroundColor);
                }
            }
            $frames[] = $image;
        }
        $this->buffer = [];

        $animGif = new AnimGif();
        try
        {
            $animGif->create($frames, 1);
            $animGif->save("out/output.gif");
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * Returns the description of the Output.
     * @return string description.
     */
    public function description(): string
    {
        return "Outputs the Board as a gif.";
    }
}