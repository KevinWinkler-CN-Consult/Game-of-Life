<?php

namespace Input;

require_once "GetOptMock.php";

use GetOptMock;
use GOL\Boards\Board;
use GOL\Input\Acorn;
use PHPUnit\Framework\TestCase;

class AcornTest extends TestCase
{
    protected $input;
    protected $getOpt;

    protected function setUp(): void
    {
        $this->input = new Acorn();
        $this->getOpt = new GetOptMock();
    }

    /**
     * @test
     */
    public function prepareBoard()
    {
        $board = new Board(9, 5);
        $array = [
            [0, 0, 0, 0, 0],
            [0, 1, 0, 0, 0],
            [0, 1, 0, 1, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 1, 0, 0],
            [0, 1, 0, 0, 0],
            [0, 1, 0, 0, 0],
            [0, 1, 0, 0, 0],
            [0, 0, 0, 0, 0]];

        $this->input->prepareBoard($board, $this->getOpt);

        $this->assertEquals($array, $board->getGrid());
    }

    /**
     * @test
     */
    public function prepareSmallBoard()
    {
        $board = new Board(5, 5);
        $array = [
            [0, 1, 0, 1, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 1, 0, 0],
            [0, 1, 0, 0, 0],
            [0, 1, 0, 0, 0]];

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
