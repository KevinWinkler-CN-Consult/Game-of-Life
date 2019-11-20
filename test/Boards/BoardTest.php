<?php

namespace Boards;

use GOL\Boards\Board;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    protected $board;

    protected function setUp(): void
    {
        $this->board = new Board(5, 5);
    }

    private function isGridZero($_grid)
    {
        $isEmpty = true;
        foreach ($_grid as $row)
        {
            foreach ($row as $cell)
            {
                if ($cell != 0)
                    $isEmpty = false;
            }
        }
        return $isEmpty;
    }

    /**
     * @test
     */
    public function constructedWidthIsActualWidth()
    {
        $this->assertEquals(5, $this->board->width());
    }

    /**
     * @test
     */
    public function constructedHeightIsActualHeight()
    {
        $this->assertEquals(5, $this->board->height());
    }

    /**
     * @test
     */
    public function constructedBoardIsEmpty()
    {
        $grid = $this->board->getGrid();

        $isEmpty = $this->isGridZero($grid);

        $this->assertTrue($isEmpty);
    }

    /**
     * @test
     */
    public function setGridCreatesNonEmptyGrid()
    {
        $this->board->setCell(0, 0, 1);
        $grid = $this->board->getGrid();

        $isEmpty = $this->isGridZero($grid);

        $this->assertNotTrue($isEmpty);
    }

    /**
     * @test
     */
    public function setGridOutOfBoundCreatesNonEmptyGrid()
    {
        $this->board->setCell(-1, 0, 1);
        $grid = $this->board->getGrid();

        $isEmpty = $this->isGridZero($grid);

        $this->assertTrue($isEmpty);
    }

    /**
     * @test
     */
    public function compareEqualBoardsReturnsTrue()
    {
        $emptyBoard = new Board(5, 5);
        $this->assertTrue($this->board->compare($emptyBoard));
    }

    /**
     * @test
     */
    public function compareNotEqualBoardsReturnsTrue()
    {
        $nonEmptyBoard = new Board(5, 5);
        $nonEmptyBoard->setCell(0, 0, 1);
        $this->assertNotTrue($this->board->compare($nonEmptyBoard));
    }

    /**
     * @test
     */
    public function emptyBoardYieldsEmptyBoardAfterNextGeneration()
    {
        $emptyBoard = new Board(5, 5);
        $this->board->nextGeneration();
        $this->assertTrue($this->board->compare($emptyBoard));
    }

    /**
     * @test
     */
    public function nextGeneration()
    {
        $emptyBoard = new Board(5, 5);

        $this->board->setCell(1, 1, 1);
        $this->board->setCell(2, 1, 1);
        $this->board->setCell(3, 1, 1);

        $this->board->nextGeneration();

        $this->assertNotTrue($this->board->compare($emptyBoard));
    }
}
