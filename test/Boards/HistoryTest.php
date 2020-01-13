<?php

namespace Boards;

use GOL\Boards\Board;
use GOL\Boards\History;
use PHPUnit\Framework\TestCase;

class HistoryTest extends TestCase
{
    protected $emptyBoard;
    protected $history;

    protected function setUp(): void
    {
        $this->emptyBoard = new Board(5, 5);
        $this->history = new History($this->emptyBoard);
    }

    /**
     * @test
     */
    public function pushIncreasesStackSize()
    {
        $this->assertEquals(1, $this->history->stackSize());
        $this->history->push($this->emptyBoard);
        $this->assertEquals(2, $this->history->stackSize());
    }

    /**
     * @test
     */
    public function popDecreasesStackSize()
    {
        $this->assertEquals(1, $this->history->stackSize());
        $this->history->removeOldestBoard();
        $this->assertEquals(0, $this->history->stackSize());
    }

    /**
     * @test
     */
    public function popFromEmptyHistory()
    {
        $this->history->removeOldestBoard();
        $this->assertEquals(0, $this->history->stackSize());
        $this->history->removeOldestBoard();
        $this->assertEquals(0, $this->history->stackSize());
    }

    /**
     * @test
     */
    public function compareEqualBoard()
    {
        $this->assertTrue($this->history->compare($this->emptyBoard));
    }

    /**
     * @test
     */
    public function compareUnequalBoard()
    {
        $board = new Board(5, 5);
        $board->setCell(0, 0, 1);
        $this->assertNotTrue($this->history->compare($board));
    }
}
