<?php

namespace GOL;

use GOL\Boards\Board;
use GOL\Rules\StandardRule;
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
        $gol = new GameLogic($board,new StandardRule());

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
        $gol = new GameLogic($board,new StandardRule());

        $board->setFieldValue(1, 1, 1);
        $board->setFieldValue(1, 2, 1);
        $board->setFieldValue(1, 3, 1);

        $ref->setFieldValue(0, 2, 1);
        $ref->setFieldValue(1, 2, 1);
        $ref->setFieldValue(2, 2, 1);

        $gol->nextGeneration($board);

        $this->assertTrue($ref->compare($board));
    }

    /**
     * @test
     */
    public function loopDetection()
    {
        $board = new Board(4, 4);

        $board->setFieldValue(1, 1, 1);
        $board->setFieldValue(1, 2, 1);
        $board->setFieldValue(1, 3, 1);

        $gol = new GameLogic($board,new StandardRule());

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

        $board->setFieldValue(6, 0, 1);

        $board->setFieldValue(4, 1, 1);
        $board->setFieldValue(5, 1, 1);
        $board->setFieldValue(6, 1, 1);

        $board->setFieldValue(3, 2, 1);
        $board->setFieldValue(7, 2, 1);
        $board->setFieldValue(8, 2, 1);

        $board->setFieldValue(2, 3, 1);
        $board->setFieldValue(4, 3, 1);
        $board->setFieldValue(7, 3, 1);

        $board->setFieldValue(0, 4, 1);
        $board->setFieldValue(1, 4, 1);
        $board->setFieldValue(2, 4, 1);
        $board->setFieldValue(5, 4, 1);
        $board->setFieldValue(7, 4, 1);

        $board->setFieldValue(6, 5, 1);

        $board->setFieldValue(4, 6, 1);
        $board->setFieldValue(5, 6, 1);

        $board->setFieldValue(4, 7, 1);

        $board->setFieldValue(4, 8, 1);

        $gol = new GameLogic($board,new StandardRule());
        $gol->setHistoryLength(3);

        $gol->nextGeneration($board);
        $gol->nextGeneration($board);
        $gol->nextGeneration($board);

        $this->assertTrue($gol->isLooping());
    }

    /**
     * @test
     */
    public function historyDeletesToOldBoards()
    {
        $board = new Board(4, 4);
        $gol = new GameLogic($board,new StandardRule());

        $gol->nextGeneration($board);
        $gol->nextGeneration($board);
        $gol->nextGeneration($board);

        $this->assertTrue($gol->isLooping());
    }
}
