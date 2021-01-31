<?php


class Application
{
    private $kernel;

    function __construct($ker)
    {
        $this->kernel = $ker;
    }
}