<?php

namespace GOL;

use GOL\Boards\Board;
use GOL\Output\Console;
use PHPUnit\Framework\TestCase;

class GameLogicTest extends TestCase
{
    /**
     * @test
     */
    public function emptyBoardYieldsEmptyBoard()
    {
        $board = new Board(4, 4);
        $ref = new Board(4, 4);
        $gol = new GameLogic($board);

        $gol->nextGeneration($board);

        $this->assertTrue($ref->compare($board));
    }

    /**
     * @test
     */
    public function nonEmptyBoardYieldsNonEmptyBoard()
    {
        $board = new Board(4, 4);
        $ref = new Board(4, 4);
        $gol = new GameLogic($board);

        $board->setCell(1, 1, 1);
        $board->setCell(1, 2, 1);
        $board->setCell(1, 3, 1);

        $ref->setCell(0, 2, 1);
        $ref->setCell(1, 2, 1);
        $ref->setCell(2, 2, 1);

        $gol->nextGeneration($board);
        $out = new Console();
        $out->write($board);
        $this->assertTrue($ref->compare($board));
    }

    /**
     * @test
     */
    public function loopDetection()
    {
        $board = new Board(4, 4);

        $board->setCell(1, 1, 1);
        $board->setCell(1, 2, 1);
        $board->setCell(1, 3, 1);

        $gol = new GameLogic($board);

        $gol->nextGeneration($board);
        $gol->nextGeneration($board);

        $this->assertTrue($gol->isLooping());
    }

    /**
     * @test
     */
    public function period3LoopDetection()
    {
        $board = new Board(10, 10);

        $board->setCell(6, 0, 1);

        $board->setCell(4, 1, 1);
        $board->setCell(5, 1, 1);
        $board->setCell(6, 1, 1);

        $board->setCell(3, 2, 1);
        $board->setCell(7, 2, 1);
        $board->setCell(8, 2, 1);

        $board->setCell(2, 3, 1);
        $board->setCell(4, 3, 1);
        $board->setCell(7, 3, 1);

        $board->setCell(0, 4, 1);
        $board->setCell(1, 4, 1);
        $board->setCell(2, 4, 1);
        $board->setCell(5, 4, 1);
        $board->setCell(7, 4, 1);

        $board->setCell(6, 5, 1);

        $board->setCell(4, 6, 1);
        $board->setCell(5, 6, 1);

        $board->setCell(4, 7, 1);

        $board->setCell(4, 8, 1);

        $gol = new GameLogic($board);
        $gol->setHistoryLength(3);

        $gol->nextGeneration($board);
        $gol->nextGeneration($board);
        $gol->nextGeneration($board);

        $this->assertTrue($gol->isLooping());
    }

    /**
     * @test
     */
    public function historyPop()
    {
        $board = new Board(4, 4);
        $gol = new GameLogic($board);

        $gol->nextGeneration($board);
        $gol->nextGeneration($board);
        $gol->nextGeneration($board);

        $this->assertTrue($gol->isLooping());
    }
}
