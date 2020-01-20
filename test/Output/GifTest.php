<?php

namespace Output;

use GetOpt\GetOpt;
use GetOpt\Option;
use GifCreator\AnimGif;
use GOL\Boards\Board;
use GOL\Helper\Clock;
use GOL\Output\Gif;
use PHPUnit\Framework\TestCase;

class GifTest extends TestCase
{
    protected $output;
    protected $board;
    protected $getopt;
    protected $animGif;

    protected function setUp(): void
    {
        $this->output = new Gif();
        $this->board = new Board(5, 5);
        $this->getopt = $this->createMock(GetOpt::class);
        $this->animGif = new AnimGif();
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
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 0, 0, 0);
        imagecolorallocate($image, 255, 255, 255);
        imagepng($image, "out/0.png");
        $this->animGif->create(["out/0.png", "out/0.png"], 1);
        $this->animGif->save("in/out.gif");

        $this->assertEquals(file_get_contents("in/out.gif"), file_get_contents("out/output.gif"));
    }

    /**
     * @test
     */
    public function writeBoard()
    {
        $this->output->checkParameters($this->getopt);
        $this->output->write($this->board);
        $this->board->setCell(0, 0, 1);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 0, 0, 0);
        $t = imagecolorallocate($image, 255, 255, 255);
        imagepng($image, "out/0.png");
        imagesetpixel($image, 0, 0, $t);
        imagepng($image, "out/1.png");
        $this->animGif->create(["out/0.png", "out/1.png"], 1);
        $this->animGif->save("in/out.gif");

        $this->assertEquals(file_get_contents("in/out.gif"), file_get_contents("out/output.gif"));
    }

    /**
     * @test
     */
    public function writeBoardWithDifferentColor()
    {
        $this->getopt->method("getOption")
                     ->willReturnMap([["gifBackgroundColor", false, "255,255,255"], ["gifCellColor", false, "0,0,0"]]);
        $this->output->checkParameters($this->getopt);
        $this->output->write($this->board);
        $this->board->setCell(0, 0, 1);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 255, 255, 255);
        $t = imagecolorallocate($image, 0, 0, 0);
        imagepng($image, "out/0.png");
        imagesetpixel($image, 0, 0, $t);
        imagepng($image, "out/1.png");
        $this->animGif->create(["out/0.png", "out/1.png"], 1);
        $this->animGif->save("in/out.gif");

        $this->assertEquals(file_get_contents("in/out.gif"), file_get_contents("out/output.gif"));
    }

    /**
     * @test
     */
    public function writeBoardWithHolidayColors()
    {
        $clock = $this->createMock(Clock::class);
        $clock->method("date")->willReturn("31-10");
        $this->output->overrideClock($clock);
        $this->output->checkParameters($this->getopt);
        $this->output->write($this->board);
        $this->board->setCell(0, 0, 1);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 0, 0, 0);
        $t = imagecolorallocate($image, 255, 153, 0);
        imagepng($image, "out/0.png");
        imagesetpixel($image, 0, 0, $t);
        imagepng($image, "out/1.png");
        $this->animGif->create(["out/0.png", "out/1.png"], 1);
        $this->animGif->save("in/out.gif");

        $this->assertEquals(file_get_contents("in/out.gif"), file_get_contents("out/output.gif"));
    }

    /**
     * @test
     */
    public function writeBoardWithNoHolidayColorsIfCustomColorIsSet()
    {
        $this->getopt->method("getOption")
                     ->willReturnMap([["gifBackgroundColor", false, "255,255,255"], ["gifCellColor", false, "0,0,0"]]);
        $this->output->checkParameters($this->getopt);
        $clock = $this->createMock(Clock::class);
        $clock->method("date")->willReturn("31-10");
        $this->output->overrideClock($clock);
        $this->output->write($this->board);
        $this->board->setCell(0, 0, 1);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 255, 255, 255);
        $t = imagecolorallocate($image, 0, 0, 0);
        imagepng($image, "out/0.png");
        imagesetpixel($image, 0, 0, $t);
        imagepng($image, "out/1.png");
        $this->animGif->create(["out/0.png", "out/1.png"], 1);
        $this->animGif->save("in/out.gif");

        $this->assertEquals(file_get_contents("in/out.gif"), file_get_contents("out/output.gif"));
    }

    /**
     * @test
     */
    public function writeBoardWithDifferentCellSize()
    {
        $this->getopt->method("getOption")
                     ->willReturnMap([["gifCellSize", false, "2"]]);
        $this->output->checkParameters($this->getopt);
        $this->output->write($this->board);
        $this->board->setCell(0, 0, 1);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(10, 10);
        imagecolorallocate($image, 0, 0, 0);
        $t = imagecolorallocate($image, 255, 255, 255);
        imagepng($image, "out/0.png");
        imagesetpixel($image, 0, 0, $t);
        imagesetpixel($image, 1, 0, $t);
        imagesetpixel($image, 0, 1, $t);
        imagesetpixel($image, 1, 1, $t);
        imagepng($image, "out/1.png");
        $this->animGif->create(["out/0.png", "out/1.png"], 1);
        $this->animGif->save("in/out.gif");

        $this->assertEquals(file_get_contents("in/out.gif"), file_get_contents("out/output.gif"));
    }

    /**
     * @test
     */
    public function writeBoardWithDifferentDelay()
    {
        $this->getopt->method("getOption")
                     ->willReturnMap([["gifDelay", false, "2"]]);
        $this->output->checkParameters($this->getopt);
        $this->output->write($this->board);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 0, 0, 0);
        imagecolorallocate($image, 255, 255, 255);
        imagepng($image, "out/0.png");
        $this->animGif->create(["out/0.png", "out/0.png"], 2);
        $this->animGif->save("in/out.gif");

        $this->assertEquals(file_get_contents("in/out.gif"), file_get_contents("out/output.gif"));
    }

    /**
     * @test
     */
    public function writeBoardWithDifferentDelay3()
    {
        $this->getopt->method("getOption")
                     ->willReturnMap([["gifDelay", false, "2"]]);
        $this->output->checkParameters($this->getopt);
        $this->output->write($this->board);
        $this->output->flush();
        $this->assertTrue(true);
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
