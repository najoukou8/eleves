<?php
// bootstrap.php
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Mapping\AnsiQuoteStrategy;

$container = require __DIR__."/src/container.php" ;
error_reporting(E_ERROR | E_PARSE);


$entitiesPath = [
    join(DIRECTORY_SEPARATOR, [__DIR__, "src", "Entity"])
];

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;


$dbParams = [
    'driver'   => 'pdo_mysql',
    'host'     => $container->getParameter('parameters')['parameters']['db_host'] ,
    'charset'  => 'utf8',
    'user'     => $container->getParameter('parameters')['parameters']['db_username'] ,
    'password' => $container->getParameter('parameters')['parameters']['db_password'] ,
    'dbname'   => $container->getParameter('parameters')['parameters']['db_name']  ,
];


$config = Setup::createAnnotationMetadataConfiguration(
    $entitiesPath,
    $isDevMode,
    $proxyDir,
    $cache,
    $useSimpleAnnotationReader
);


    $entityManager  = EntityManager::create($dbParams          , $config);



    return $entityManager ;
