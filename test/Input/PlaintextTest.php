<?php

namespace Input;

use GetOpt\GetOpt;
use GetOpt\Option;
use GOL\Boards\Board;
use GOL\Input\Plaintext;
use PHPUnit\Framework\TestCase;

class PlaintextTest extends TestCase
{
    protected $input;
    protected $getOpt;

    protected function setUp(): void
    {
        $this->input = new Plaintext();
        $this->getOpt = $this->createMock(GetOpt::class);
        $file = fopen("in/plain.cells", "w");
        fwrite($file,
               "!Name: Glider\n" .
               "!Author: Richard K. Guy\n" .
               "!The smallest, most common, and first discovered spaceship.\n" .
               "!www.conwaylife.com/wiki/index.php?title=Glider\n" .
               ".O\n" .
               "O.O\n" .
               "OOO\n");
        fclose($file);
    }

    /**
     * @test
     */
    public function prepareBoardWithEmptyArgument()
    {
        $board = new Board(5, 5);
        $array = [
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0]];

        $this->input->prepareBoard($board, $this->getOpt);

        $this->assertEquals($array, $board->getGrid());
    }

    /**
     * @test
     */
    public function prepareBoardWithArgument()
    {
        $this->getOpt->method("getOption")
                     ->with("plaintextFile")
                     ->willReturn("in/plain.cells");

        $board = new Board(5, 5);
        $array = [
            [0, 1, 1, 0, 0],
            [1, 0, 1, 0, 0],
            [0, 1, 1, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0]];

        $this->input->prepareBoard($board, $this->getOpt);

        $this->assertEquals($array, $board->getGrid());
    }

    /**
     * @test
     */
    public function prepareSmallBoardWithArgument()
    {
        $this->getOpt->method("getOption")
                     ->with("plaintextFile")
                     ->willReturn("in/plain.cells");

        $board = new Board(2, 2);
        $array = [
            [0, 1],
            [1, 0]];

        $this->input->prepareBoard($board, $this->getOpt);

        $this->assertEquals($array, $board->getGrid());
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
    public function description()
    {
        $this->assertIsString($this->input->description());
    }
}
