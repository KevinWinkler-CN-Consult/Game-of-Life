<?php

use GetOpt\GetOpt;

class GetOptMock extends GetOpt
{
    private $optionsMock = [];

    public function __construct(array $_options = [])
    {
        $this->optionsMock = $_options;
        parent::__construct();
    }

    public function setOptions(array $_options = [])
    {
        $this->optionsMock = $_options;
    }

    public function getOption($name, $object = false)
    {
        return isset($this->optionsMock[$name]) ? $this->optionsMock[$name] : null;
    }
}