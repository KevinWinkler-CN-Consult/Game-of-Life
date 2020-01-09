<?php

namespace Output;

use ClockMock;
use GetOpt\Option;
use GetOptMock;
use GOL\Boards\Board;
use GOL\Output\Video;
use PHPUnit\Framework\TestCase;

class VideoTest extends TestCase
{
    protected $output;
    protected $board;
    protected $getopt;

    protected function setUp(): void
    {
        $this->output = new Video();
        $this->board = new Board(5, 5);
        $this->getopt = new GetOptMock();
        foreach (glob("out/*") as $filename)
        {
            unlink($filename);
        }
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
        imagepng($image, "out/000.png");

        exec("rm in/video.avi");
        exec("ffmpeg -framerate 30 -i out/000.png in/video.avi");

        $this->assertEquals(file_get_contents("in/video.avi"), file_get_contents("out/video.avi"));
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
        imagepng($image, "out/000.png");

        exec("rm in/video.avi");
        exec("ffmpeg -framerate 30 -i out/000.png in/video.avi");

        $this->assertEquals(file_get_contents("in/video.avi"), file_get_contents("out/video.avi"));
    }

    /**
     * @test
     */
    public function writeBoardWithDifferentColors()
    {
        $this->getopt->setOptions(["videoBackgroundColor" => "255,255,255", "videoCellColor" => "0,0,0"]);
        $this->output->checkParameters($this->getopt);
        $this->board->setCell(0, 0, 1);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 255, 255, 255);
        $t = imagecolorallocate($image, 0, 0, 0);
        imagesetpixel($image, 0, 0, $t);
        imagepng($image, "out/000.png");

        exec("rm in/video.avi");
        exec("ffmpeg -framerate 30 -i out/000.png in/video.avi");

        $this->assertEquals(file_get_contents("in/video.avi"), file_get_contents("out/video.avi"));
    }

    /**
     * @test
     */
    public function writeBoardWithHolidayColors()
    {
        $this->output->overrideClock(new ClockMock("31-10"));
        $this->output->checkParameters($this->getopt);
        $this->board->setCell(0, 0, 1);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 0, 0, 0);
        $t = imagecolorallocate($image, 255, 153, 0);
        imagesetpixel($image, 0, 0, $t);
        imagepng($image, "out/000.png");

        exec("rm in/video.avi");
        exec("ffmpeg -framerate 30 -i out/000.png in/video.avi");

        $this->assertEquals(file_get_contents("in/video.avi"), file_get_contents("out/video.avi"));
    }

    /**
     * @test
     */
    public function writeBoardWithNoHolidayColorsIfCustomColorIsSet()
    {
        $this->output->overrideClock(new ClockMock("31-10"));
        $this->getopt->setOptions(["videoBackgroundColor" => "255,255,255", "videoCellColor" => "0,0,0"]);
        $this->output->checkParameters($this->getopt);
        $this->board->setCell(0, 0, 1);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 255, 255, 255);
        $t = imagecolorallocate($image, 0, 0, 0);
        imagesetpixel($image, 0, 0, $t);
        imagepng($image, "out/000.png");

        exec("rm in/video.avi");
        exec("ffmpeg -framerate 30 -i out/000.png in/video.avi");

        $this->assertEquals(file_get_contents("in/video.avi"), file_get_contents("out/video.avi"));
    }

    /**
     * @test
     */
    public function writeBoardWithDifferentCellSize()
    {
        $this->getopt->setOptions(["videoCellSize" => "2"]);
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
        imagepng($image, "out/000.png");

        exec("rm in/video.avi");
        exec("ffmpeg -framerate 30 -i out/000.png in/video.avi");

        $this->assertEquals(file_get_contents("in/video.avi"), file_get_contents("out/video.avi"));
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
