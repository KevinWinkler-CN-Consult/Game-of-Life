<?php

namespace Output;

use GOL\Boards\Board;
use GOL\Output\Console;
use PHPUnit\Framework\TestCase;

class ConsoleTest extends TestCase
{
    protected $output;
    protected $board;

    protected function setUp(): void
    {
        $this->output = new Console();
        $this->board = new Board(5, 5);
    }

    /**
     * @test
     */
    public function writeEmptyBoard()
    {
        $this->expectOutputString("-----\n-----\n-----\n-----\n-----\n\n");
        $this->output->write($this->board);
    }

    /**
     * @test
     */
    public function writeBoard()
    {
        $this->expectOutputString("O----\n-----\n-----\n-----\n-----\n\n");
        $this->board->setFieldValue(0, 0, 1);
        $this->output->write($this->board);
    }

    /**
     * @test
     */
    public function description()
    {
        $this->assertIsString($this->output->description());
    }
}
