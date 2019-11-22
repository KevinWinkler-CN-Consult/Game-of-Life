<?php

namespace Input;

require_once "ReadlineMock.php";

use GetOptMock;
use GOL\Boards\Board;
use GOL\Input\User;
use PHPUnit\Framework\TestCase;
use ReadlineMock;

class UserTest extends TestCase
{
    protected $input;
    protected $getOpt;

    protected function setUp(): void
    {
        $this->input = new User();
        $this->getOpt = new GetOptMock();
    }

    /**
     * @test
     */
    public function emptyBoardOnFinish()
    {
        $board = new Board(3, 3);
        $array = [
            [0, 0, 0],
            [0, 0, 0],
            [0, 0, 0]
        ];

        $readline = new ReadlineMock();
        $readline->setLines(["finish"]);

        $this->input->setReadline($readline);
        $this->input->prepareBoard($board, $this->getOpt);

        $this->assertEquals($array, $board->getGrid());
    }

    /**
     * @test
     */
    public function boardOnFinish()
    {
        $board = new Board(3, 3);
        $array = [
            [0, 0, 0],
            [0, 1, 0],
            [0, 0, 0]
        ];

        $readline = new ReadlineMock();
        $readline->setLines([
                                "1,1",
                                "finish"
                            ]);

        $this->input->setReadline($readline);
        $this->input->prepareBoard($board, $this->getOpt);

        $this->assertEquals($array, $board->getGrid());
    }

    /**
     * @test
     */
    public function boardOnFinish2()
    {
        $board = new Board(3, 3);
        $array = [
            [0, 0, 0],
            [0, 1, 0],
            [0, 0, 0]
        ];

        $readline = new ReadlineMock();
        $readline->setLines([
                                "1,1,1",
                                "finish"
                            ]);

        $this->input->setReadline($readline);
        $this->input->prepareBoard($board, $this->getOpt);

        $this->assertEquals($array, $board->getGrid());
    }

    /**
     * @test
     */
    public function emptyBoardOnOutOfBounds()
    {
        $board = new Board(3, 3);
        $array = [
            [0, 0, 0],
            [0, 0, 0],
            [0, 0, 0]
        ];

        $readline = new ReadlineMock();
        $readline->setLines([
                                "1,3,1",
                                "finish"
                            ]);

        $this->input->setReadline($readline);
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
