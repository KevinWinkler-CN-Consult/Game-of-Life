<?php

use GOL\Helper\Readline;

class ReadlineMock extends Readline
{
    private $lines = [];
    private $index = 0;

    public function setLines(array $_lines)
    {
        $this->lines = $_lines;
    }

    public function readline($prompt = null)
    {
        return (isset ($this->lines[$this->index]) ? $this->lines[$this->index++] : '\n');
    }
}