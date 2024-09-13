<?php
error_reporting(E_ERROR | E_PARSE);
require __DIR__."/../vendor/autoload.php" ;

use Bundles\AppBundle\EventListener\CreateUserListenner;
use Bundles\AppBundle\EventListener\GoogleListener;
use Core\Event\CreateUserEvent;
use Core\Event\ResponseEvent;
use Core\Framework;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Yaml\Yaml;
use Monolog\Handler\FirePHPHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Setup;


$containerBuilder = new DependencyInjection\ContainerBuilder();
$containerBuilder->register("session" , Session::class ) ;
$containerBuilder->register('context', Routing\RequestContext::class);
$containerBuilder->register('matcher', Routing\Matcher\UrlMatcher::class)
    ->setArguments([$routes, new Reference('context')])
;
$containerBuilder->register('request_stack', HttpFoundation\RequestStack::class);
$containerBuilder->register('controller_resolver', HttpKernel\Controller\ControllerResolver::class);
$containerBuilder->register('argument_resolver', HttpKernel\Controller\ArgumentResolver::class);
$containerBuilder->register('dispatcher', EventDispatcher\EventDispatcher::class);


$containerBuilder->register('dispatcher', EventDispatcher\EventDispatcher::class)
    //->addMethodCall('addListener', array( ResponseEvent::EVENT_NAME , array(new GoogleListener() ,        'onResponse' ) , 1  ))
    //->addMethodCall('addListener', array( CreateUserEvent::EVENT_NAME , array(new CreateUserListenner() , 'createNewUserEvent' ) , 1  )) ;
;

$containerBuilder->register('framework', Framework::class)
    ->setArguments([
        new Reference('matcher'),
        new Reference('controller_resolver'),
        new Reference('argument_resolver'),
        new Reference('dispatcher'),
    ])
;

$dateFormat = "j/n/Y  g:i";

$output = "%datetime% \t %level_name% \t %message%\n";

$formatter = new LineFormatter($output, $dateFormat);
$stream = new StreamHandler("/tmp/log.log", Logger::DEBUG);
$stream->setFormatter($formatter);


$securityLogger = new Logger('security');
$securityLogger->pushHandler($stream);


$containerBuilder->set('logger' , $securityLogger ) ;

$parameters = Yaml::parseFile(__DIR__."/../config/parameters.yaml");
$containerBuilder->setParameter("parameters" , $parameters) ;

$bdd = new \PDO(
    "mysql:host={$containerBuilder->getParameter('parameters')['parameters']['db_host']};dbname={$containerBuilder->getParameter('parameters')['parameters']['db_name']};charset=utf8",
    "{$containerBuilder->getParameter('parameters')['parameters']['db_username']}",
    "{$containerBuilder->getParameter('parameters')['parameters']['db_password']}"
);



$entitiesPath = [
    join(DIRECTORY_SEPARATOR, [__DIR__, "src", "Entity"])
];

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;

// Connexion à la base de données
$dbParams = [
    'driver'   => 'pdo_mysql',
    'host'     => $containerBuilder->getParameter('parameters')['parameters']['db_host'] ,
    'charset'  => 'utf8',
    'user'     => $containerBuilder->getParameter('parameters')['parameters']['db_username'] ,
    'password' => $containerBuilder->getParameter('parameters')['parameters']['db_password'] ,
    'dbname'   => $containerBuilder->getParameter('parameters')['parameters']['db_name'] ,
];

$config = Setup::createAnnotationMetadataConfiguration(
    $entitiesPath,
    $isDevMode,
    $proxyDir,
    $cache,
    $useSimpleAnnotationReader
);


$em_ = EntityManager::create($dbParams, $config);

$containerBuilder->set('entityManager' , $bdd  ) ;
$containerBuilder->set('_em' , $em_  ) ;

return $containerBuilder;

