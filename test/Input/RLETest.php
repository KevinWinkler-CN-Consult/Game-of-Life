<?php

namespace Input;

use GetOptMock;
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
        $this->getOpt = new GetOptMock();

        $file = fopen("in/plain.rle", "w");
        fwrite($file,
               '#N Glider
#O Richard K. Guy
#C The smallest, most common, and first discovered spaceship. Diagonal, has period 4 and speed c/4.
#C www.conwaylife.com/wiki/index.php?title=Glider
x = 3, y = 3, rule = B3/S23
bob$2bo$3o!');
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
        $this->getOpt->setOptions(["rleFile" => "in/plain.rle"]);

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
        $this->getOpt->setOptions(["rleFile" => "in/plain.rle"]);

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
        $this->getOpt->setOptions(["rleFile" => "in/plain.rle", "rlePosition" => "0,0"]);

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
        $this->getOpt->setOptions(["rleFile" => "in/plain.rle"]);

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
    public function description()
    {
        $this->assertIsString($this->input->description());
    }
}
