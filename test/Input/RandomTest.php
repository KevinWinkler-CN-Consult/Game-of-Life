<?php

namespace Input;

use GetOpt\GetOpt;
use GetOpt\Option;
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
        $this->getOpt = $this->createMock(GetOpt::class);
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
     * @test
     */
    public function prepareBoardWithDensity90()
    {
        $board = new Board(5, 5);
        $this->getOpt->method("getOption")
                     ->with("randomDensity")
                     ->willReturn("90");

        $this->input->prepareBoard($board, $this->getOpt);

        $this->assertNotTrue($this->isGridZero($board->getGrid()));
    }

    /**
     * @test
     */
    public function register()
    {
        $options = $this->input->register();
        $this->assertIsArray($options);
        foreach ($options as $option)
        {
            $this->assertTrue($option instanceof Option);
        }
    }

    /**
     * @test
     */
    public function prepareBoardWithDensity0()
    {
        $board = new Board(5, 5);
        $this->getOpt->method("getOption")
                     ->with("randomDensity")
                     ->willReturn("0");
        $array = [
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0]
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
