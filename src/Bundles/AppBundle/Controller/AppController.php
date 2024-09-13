<?php

namespace Bundles\AppBundle\Controller;

use Bundles\AppBundle\Model\User;
use Core\AbstrcatController;
use Core\Event\CreateUserEvent;
use Faker\Factory;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class AppController extends AbstrcatController
{

    private $log ;

    public function __construct()
    {
        parent::__construct(__DIR__."/../Templates");
    }

    public function index($year )
    {

        $faker = Factory::create();
        $dispatcher = $this->container->get('dispatcher') ;
        for ($i = 0; $i < 100 ; $i++) {
            $collectionModel[] =  $faker ;
            $newUser = new User($faker->userName,$faker->lastName ) ;
            $dispatcher->dispatch( $newUser  ,  CreateUserEvent::EVENT_NAME );
            $this->container->get('logger')->warning($faker->email);
        }


        return $this->renderViewTwig(
            'home/home.html.twig' , array(
                'name' =>  $year , "all" => $collectionModel , "LightFrameWork" => $year , 'login' => $login
            )
        ) ;
    }


    public function php(int  $max)
    {

        $collectionModel = array() ;
        $faker = Factory::create();
        for ($i = 0; $i < $max ; $i++) {
            $collectionModel[] =  $faker ;
        }

        return $this->renderViewPhp(
            __DIR__.'/../Templates/home/home.html.php' , $collectionModel
        ) ;
    }

}
