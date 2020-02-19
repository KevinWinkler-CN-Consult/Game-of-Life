<?php

namespace Input;

use GetOpt\GetOpt;
use GOL\Boards\Board;
use GOL\Input\User;
use Icecave\Isolator\Isolator;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    protected $input;
    protected $getOpt;
    protected $readline;

    protected function setUp(): void
    {
        $this->input = new User();
        $this->getOpt = $this->createMock(GetOpt::class);
        $this->readline = $this->createMock(Isolator::class);
        $this->input->setIsolator($this->readline);
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

        $this->readline->method("readline")
                       ->with($this->anything())
                       ->willReturn("finish");

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

        $this->readline->method("readline")
                       ->with($this->anything())
                       ->willReturnOnConsecutiveCalls("1,1","finish");

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

        $this->readline->method("readline")
                       ->with($this->anything())
                       ->willReturnOnConsecutiveCalls("1,1,1","finish");

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
        $this->readline->method("readline")
                       ->with($this->anything())
                       ->willReturn("1,3,1")
                       ->willReturn("finish");

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
