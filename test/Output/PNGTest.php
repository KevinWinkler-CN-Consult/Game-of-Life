<?php

namespace Test\Output;

use GetOpt\GetOpt;
use GetOpt\Option;
use GOL\Boards\Board;
use GOL\Output\Png;
use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;

class PNGTest extends TestCase
{
    protected $output;
    protected $board;
    protected $getopt;
    protected $time;

    use PHPMock;

    protected function setUp(): void
    {
        $this->output = new Png();
        $this->board = new Board(5, 5);
        $this->getopt = $this->createMock(GetOpt::class);
        $this->time = $this->getFunctionMock("GOL","date");
    }

    /**
     * @test
     */
    public function writeEmptyBoard()
    {
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
        $this->getopt->method("getOption")
                     ->willReturnMap([["pngBackgroundColor", false, "255,255,255"], ["pngCellColor", false, "0,0,0"]]);
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
        $this->time->expects($this->any())->willReturn("31-10");
        $this->output->checkParameters($this->getopt);

        $this->board->setFieldValue(0, 0, 1);
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
        $this->getopt->method("getOption")
                     ->willReturnMap([["pngBackgroundColor", false, "255,255,255"], ["pngCellColor", false, "0,0,0"]]);
        $this->time->expects($this->any())->willReturn("31-10");
        $this->output->checkParameters($this->getopt);
        $this->board->setFieldValue(0, 0, 1);
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
        $this->getopt->method("getOption")
                     ->willReturnMap([["pngCellSize", false, "2"]]);
        $this->output->checkParameters($this->getopt);
        $this->board->setFieldValue(0, 0, 1);
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
        $this->board->setFieldValue(0, 0, 1);
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
        $this->getopt->method("getOption")
                     ->willReturnMap([["pngBackgroundColor", false, "255,255,255"], ["pngCellColor", false, "0,0,0"]]);
        $this->output->checkParameters($this->getopt);
        $this->board->setFieldValue(0, 0, 1);
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
