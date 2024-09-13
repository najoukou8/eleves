<?php

namespace Core\Command;

use Symfony\Component\Console\Command\Command;

class GiCommand extends Command
{
    protected $container ;
    protected $bootstrap ;
    public function __construct(string $name = null)
    {
        parent::__construct($name);
        $this->container = require __DIR__."/../../container.php"   ;
        $this->bootstrap = require __DIR__."/../../../bootstrap-cli.php";
    }
}