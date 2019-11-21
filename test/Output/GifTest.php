<?php

namespace Output;

use GetOptMock;
use GifCreator\AnimGif;
use GOL\Boards\Board;
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
        $this->getopt = new GetOptMock();
        $this->animGif = new AnimGif();
        exec("rm out/*");
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
        $this->getopt->setOptions(["gifBackgroundColor" => "255,255,255", "gifCellColor" => "0,0,0"]);
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
    public function writeBoardWithDifferentCellSize()
    {
        $this->getopt->setOptions(["gifCellSize" => "2"]);
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
        $this->getopt->setOptions(["gifDelay" => "2"]);
        $this->output->checkParameters($this->getopt);
        $this->output->write($this->board);
        $this->output->write($this->board);
        $this->output->flush();

        $image = imagecreate(5, 5);
        imagecolorallocate($image, 0, 0, 0);
        $t = imagecolorallocate($image, 255, 255, 255);
        imagepng($image, "out/0.png");
        $this->animGif->create(["out/0.png", "out/0.png"], 2);
        $this->animGif->save("in/out.gif");

        $this->assertEquals(file_get_contents("in/out.gif"), file_get_contents("out/output.gif"));
    }

    /**
     * @test
     */
    public function description()
    {
        $this->assertIsString($this->output->description());
    }
}
