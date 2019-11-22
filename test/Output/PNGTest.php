<?php

namespace Output;

require_once "ClockMock.php";

use ClockMock;
use GetOpt\Option;
use GetOptMock;
use GOL\Boards\Board;
use GOL\Output\Png;
use PHPUnit\Framework\TestCase;

class PNGTest extends TestCase
{
    protected $output;
    protected $board;
    protected $getopt;

    protected function setUp(): void
    {
        $this->output = new Png();
        $this->board = new Board(5, 5);
        $this->getopt = new GetOptMock();
    }

    /**
     * @test
     */
    public function writeEmptyBoard()
    {
        $this->expectOutputString("");
        $this->output->checkParameters($this->getopt);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 0, 0, 0);
        imagecolorallocate($image, 255, 255, 255);
        imagepng($image, "in/empty.png");

        $this->assertEquals(file_get_contents("out/img-000.png"), file_get_contents("in/empty.png"));
    }

    /**
     * @test
     */
    public function writeEmptyBoardWithDifferentColors()
    {
        $this->getopt->setOptions(["pngBackgroundColor" => "255,255,255", "pngCellColor" => "0,0,0"]);
        $this->output->checkParameters($this->getopt);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 255, 255, 255);
        imagecolorallocate($image, 0, 0, 0);
        imagepng($image, "in/emptywhite.png");

        $this->assertEquals(file_get_contents("out/img-000.png"), file_get_contents("in/emptywhite.png"));
    }

    /**
     * @test
     */
    public function writeBoardWithHolidayColors()
    {
        $this->output->setClock(new ClockMock("31-10"));
        $this->output->checkParameters($this->getopt);
        $this->board->setCell(0, 0, 1);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 0, 0, 0);
        $t = imagecolorallocate($image, 255, 153, 0);
        imagesetpixel($image, 0, 0, $t);
        imagepng($image, "in/emptywhite.png");

        $this->assertEquals(file_get_contents("out/img-000.png"), file_get_contents("in/emptywhite.png"));
    }

    /**
     * @test
     */
    public function writeBoardWithNoHolidayColorsIfCustomColorIsSet()
    {
        $this->getopt->setOptions(["pngBackgroundColor" => "255,255,255", "pngCellColor" => "0,0,0"]);
        $this->output->setClock(new ClockMock("31-10"));
        $this->output->checkParameters($this->getopt);
        $this->board->setCell(0, 0, 1);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 255, 255, 255);
        $t = imagecolorallocate($image, 0, 0, 0);
        imagesetpixel($image, 0, 0, $t);
        imagepng($image, "in/emptywhite.png");

        $this->assertEquals(file_get_contents("out/img-000.png"), file_get_contents("in/emptywhite.png"));
    }

    /**
     * @test
     */
    public function writeBoardWithDifferentCellSize()
    {
        $this->getopt->setOptions(["pngCellSize" => "2"]);
        $this->output->checkParameters($this->getopt);
        $this->board->setCell(0, 0, 1);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(10, 10);
        imagecolorallocate($image, 0, 0, 0);
        $t = imagecolorallocate($image, 255, 255, 255);
        imagesetpixel($image, 0, 0, $t);
        imagesetpixel($image, 1, 0, $t);
        imagesetpixel($image, 0, 1, $t);
        imagesetpixel($image, 1, 1, $t);
        imagepng($image, "in/emptywhite.png");

        $this->assertEquals(file_get_contents("out/img-000.png"), file_get_contents("in/emptywhite.png"));
    }

    /**
     * @test
     */
    public function writeBoard()
    {

        $this->output->checkParameters($this->getopt);
        $this->board->setCell(0, 0, 1);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 0, 0, 0);
        $t = imagecolorallocate($image, 255, 255, 255);
        imagesetpixel($image, 0, 0, $t);
        imagepng($image, "in/expected.png");

        $this->assertEquals(file_get_contents("out/img-000.png"), file_get_contents("in/expected.png"));
    }

    /**
     * @test
     */
    public function writeBoardWithDifferentColors()
    {
        $this->getopt->setOptions(["pngBackgroundColor" => "255,255,255", "pngCellColor" => "0,0,0"]);
        $this->output->checkParameters($this->getopt);
        $this->board->setCell(0, 0, 1);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 255, 255, 255);
        $t = imagecolorallocate($image, 0, 0, 0);
        imagesetpixel($image, 0, 0, $t);
        imagepng($image, "in/expectedwhite.png");

        $this->assertEquals(file_get_contents("out/img-000.png"), file_get_contents("in/expectedwhite.png"));
    }

    /**
     * @test
     */
    public function register()
    {
        $options = $this->output->register();
        $this->assertIsArray($options);
        foreach ($options as $option)
        {
            $this->assertTrue($option instanceof Option);
        }
    }

    /**
     * @test
     */
    public function description()
    {
        $this->assertIsString($this->output->description());
    }
}
