<?php

namespace Input;

use GetOpt\GetOpt;
use GetOptMock;
use GOL\Boards\Board;
use GOL\Input\Glider;
use PHPUnit\Framework\TestCase;

class GliderTest extends TestCase
{
    protected $input;
    protected $getOpt;

    protected function setUp(): void
    {
        $this->input = new Glider();
        $this->getOpt = new GetOptMock();
    }

    /**
     * @test
     */
    public function prepareBoard()
    {
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
    public function prepareBoard2()
    {
        $board = new Board(3, 3);
        $array = [
            [0, 0, 1],
            [1, 0, 1],
            [0, 1, 1]];

        $this->input->prepareBoard($board, $this->getOpt);

        $this->assertEquals($array, $board->getGrid());
    }

    /**
     * @test
     */
    public function prepareBoardGetOpt()
    {
        $this->getOpt->setOptions(["gliderPosition" => "1,1"]);
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
    public function prepareBoardGetOpt2()
    {
        $this->getOpt->setOptions(["gliderPosition" => "0,0"]);
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
    public function description()
    {
        $this->assertIsString($this->input->description());
    }
}
