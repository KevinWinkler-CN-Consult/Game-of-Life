<?php

namespace Input;

use GetOptMock;
use GOL\Boards\Board;
use GOL\Input\Random;
use PHPUnit\Framework\TestCase;

class RandomTest extends TestCase
{
    protected $input;
    protected $getOpt;

    protected function setUp(): void
    {
        $this->input = new Random();
        $this->getOpt = new GetOptMock();
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
    public function prepareBoard()
    {
        $board = new Board(5, 5);

        $this->input->prepareBoard($board, $this->getOpt);

        $this->assertNotTrue($this->isGridZero($board->getGrid()));
    }

    /**
     * @testignored
     */
    public function prepareBoardWithDensity100()
    {
        $board = new Board(5, 5);
        $this->getOpt->setOptions(["randomDensity" => "100"]);
        $array = [
            [1, 1, 1, 1, 1],
            [1, 1, 1, 1, 1],
            [1, 1, 1, 1, 1],
            [1, 1, 1, 1, 1],
            [1, 1, 1, 1, 1]
        ];

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
