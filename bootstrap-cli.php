<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

$container = require __DIR__."/src/container.php" ;

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

$dbParams_giUsers = [
    'driver'   => 'pdo_mysql',
    'host'     => $container->getParameter('parameters')['parameters']['db_host'] ,
    'charset'  => 'utf8',
    'user'     => $container->getParameter('parameters')['parameters']['db_username'] ,
    'password' => $container->getParameter('parameters')['parameters']['db_password'] ,
    'dbname'   => $container->getParameter('parameters')['parameters']['db_name2']  ,
];

$db_name3 = [
    'driver'   => 'pdo_mysql',
    'host'     => $container->getParameter('parameters')['parameters']['db_host'] ,
    'charset'  => 'utf8',
    'user'     => $container->getParameter('parameters')['parameters']['db_username'] ,
    'password' => $container->getParameter('parameters')['parameters']['db_password'] ,
    'dbname'   => $container->getParameter('parameters')['parameters']['db_name3']  ,
];

$db_name4  = [
    'driver'   => 'pdo_mysql',
    'host'     => $container->getParameter('parameters')['parameters']['db_host'] ,
    'charset'  => 'utf8',
    'user'     => $container->getParameter('parameters')['parameters']['db_username'] ,
    'password' => $container->getParameter('parameters')['parameters']['db_password'] ,
    'dbname'   => $container->getParameter('parameters')['parameters']['db_name4']  ,
];


$db_name5  = [
    'driver'   => 'pdo_mysql',
    'host'     => $container->getParameter('parameters')['parameters']['db_host'] ,
    'charset'  => 'utf8',
    'user'     => $container->getParameter('parameters')['parameters']['db_username'] ,
    'password' => $container->getParameter('parameters')['parameters']['db_password'] ,
    'dbname'   => $container->getParameter('parameters')['parameters']['db_name5']  ,
];


$db_name_ast  = [
    'driver'   => 'pdo_mysql',
    'host'     => $container->getParameter('parameters')['parameters']['db_host'] ,
    'charset'  => 'utf8',
    'user'     => $container->getParameter('parameters')['parameters']['db_username'] ,
    'password' => $container->getParameter('parameters')['parameters']['db_password'] ,
    'dbname'   => $container->getParameter('parameters')['parameters']['db_name_ast']  ,
];


$config = Setup::createAnnotationMetadataConfiguration(
    $entitiesPath,
    $isDevMode,
    $proxyDir,
    $cache,
    $useSimpleAnnotationReader
);



    $entityManager1  = EntityManager::create($dbParams          , $config);
    $entityManager2  = EntityManager::create($dbParams_giUsers  , $config);
    $entityManager3  = EntityManager::create($db_name3          , $config);
    $entityManager4  = EntityManager::create($db_name4          , $config);
    $entityManager5  = EntityManager::create($db_name5          , $config);
    $entityManager6  = EntityManager::create($db_name_ast       , $config);



    return  array(
        "DB_BE"         => $entityManager1 ,
        "DB_GI_USERS"   => $entityManager2,
        "DB_QUAALITE"   => $entityManager3 ,
        "DB_QUAALITEV3" => $entityManager4 ,
        "DB_HEL"        => $entityManager5 ,
        "db_name_ast"   => $entityManager6
    )  ;




    