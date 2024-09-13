<?php



use Symfony\Component\Routing;


$routes = new Routing\RouteCollection();

$routes->add('app2', new Routing\Route('/AcmeController/home', [
    '_controller' => '\Bundles\AcmeBundle\Controller\AcmeController::index'
]));


$routes->add('app1', new Routing\Route('/AppController/index/{year}', [
    'year' => "[0-9]{4}-[0-9]{2}",
    '_controller' => '\Bundles\AppBundle\Controller\AppController::index'
]));

$routes->add('home', new Routing\Route('/AppController/home', [
    'year' => "nadir fouka",
    '_controller' => '\Bundles\AppBundle\Controller\AppController::index'
]));



return $routes;