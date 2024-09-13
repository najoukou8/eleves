<?php


/**
======================================================================
    FRONT CONTROLLER FOR THIS FRAMEWORK
    DO NOT CHANGE CODE HERE
    AUTHOR      : nadir.fouka@grenoble-inp.fr
    SOURCE      : https://packagist.org/packages/nfouka/lightframework
    LICENCE     : MIT

======================================================================
*/

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Loader\YamlFileLoader;

require_once __DIR__.'/../vendor/autoload.php';

$request = Request::createFromGlobals();
$fileLocator = new FileLocator([__DIR__."/../config"]);
$loader = new YamlFileLoader($fileLocator);
$routes = $loader->load('routes.yaml');
$container = require __DIR__."/../src/container.php" ;
$framework = $container->get('framework');
$response = $framework->handle($request);

$response->send();

