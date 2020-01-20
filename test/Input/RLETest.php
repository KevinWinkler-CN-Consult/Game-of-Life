<?php

namespace Input;

use GetOpt\GetOpt;
use GetOpt\Option;
use GOL\Boards\Board;
use GOL\Input\RLE;
use PHPUnit\Framework\TestCase;

class RLETest extends TestCase
{
    protected $input;
    protected $getOpt;

    protected function setUp(): void
    {
        $this->input = new RLE();
        $this->getOpt = $this->createMock(GetOpt::class);

        $file = fopen("in/plain.rle", "w");
        fwrite($file,
               "#N Glider\n" .
               "#O Richard K. Guy\n" .
               "#C The smallest, most common, and first discovered spaceship. Diagonal, has period 4 and speed c/4.\n" .
               "#C www.conwaylife.com/wiki/index.php?title=Glider\n" .
               "x = 3, y = 3, rule = B3/S23\n" .
               "bob$2bo$3o!\n");
        fclose($file);
    }

    /**
     * @test
     */
    public function prepareBoardWithEmptyArgument()
    {
        $board = new Board(5, 5);
        $array = [
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0]];

        $this->input->prepareBoard($board, $this->getOpt);

        $this->assertEquals($array, $board->getGrid());
    }

    /**
     * @test
     */
    public function prepareBoardWithArgument()
    {
        $this->getOpt->method("getOption")
                     ->willReturnMap([["rleFile", false, "in/plain.rle"], ["rlePosition", false, false]]);

        $board = new Board(5, 5);
        $array = [
            [0, 0, 0, 0, 0],
            [0, 0, 0, 1, 0],
            [0, 1, 0, 1, 0],
            [0, 0, 1, 1, 0],
            [0, 0, 0, 0, 0]];

        $this->input->prepareBoard($board, $this->getOpt);

        $this->assertEquals($array, $board->getGrid());
    }

    /**
     * @test
     */
    public function prepareSmallBoardWithArgument()
    {
        $this->getOpt->method("getOption")
                     ->willReturnMap([["rleFile", false, "in/plain.rle"], ["rlePosition", false, false]]);

        $board = new Board(2, 2);
        $array = [
            [0, 1],
            [1, 1]];

        $this->input->prepareBoard($board, $this->getOpt);

        $this->assertEquals($array, $board->getGrid());
    }

    /**
     * @test
     */
    public function prepareBoardWithArgumentAndPosition()
    {
        $this->getOpt->method("getOption")
                     ->willReturnMap([["rleFile", false, "in/plain.rle"], ["rlePosition", false, "0,0"]]);

        $board = new Board(5, 5);
        $array = [
            [0, 0, 1, 0, 0],
            [1, 0, 1, 0, 0],
            [0, 1, 1, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0]];

        $this->input->prepareBoard($board, $this->getOpt);

        $this->assertEquals($array, $board->getGrid());
    }

    /**
     * @test
     */
    public function prepareSmallBoardWithArgumentAndPosition()
    {
        $this->getOpt->method("getOption")
                     ->willReturnMap([["rleFile", false, "in/plain.rle"], ["rlePosition", false, false]]);

        $board = new Board(2, 2);
        $array = [
            [0, 1],
            [1, 1]];

        $this->input->prepareBoard($board, $this->getOpt);

        $this->assertEquals($array, $board->getGrid());
    }

    /**
     * @test
     */
    public function register()
    {
        $options = $this->input->register();
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
        $this->assertIsString($this->input->description());
    }
}
