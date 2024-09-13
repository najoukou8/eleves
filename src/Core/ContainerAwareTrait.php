<?php

namespace Core;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

trait ContainerAwareTrait
{
    protected $container ;

    public function init(){
        $fileLocator = new FileLocator([__DIR__."/../../config"]);
        $loader = new YamlFileLoader($fileLocator);
        $routes = $loader->load('routes.yaml');
        $this->container = require __DIR__."/../../src/container.php" ;
    }

}