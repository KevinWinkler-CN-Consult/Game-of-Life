<?php

namespace Input;

use GetOptMock;
use GOL\Input\User;
use PHPUnit\Framework\TestCase;

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
    public function description()
    {
        $this->assertIsString($this->input->description());
    }
}
