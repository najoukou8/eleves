<?php

namespace Bundles\AppBundle\EventListener;

use Bundles\AppBundle\Model\User;
use Core\ContainerAwareTrait;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

class CreateUserListenner
{

    public function createNewUserEvent(User $user) {

        $fileLocator = new FileLocator([__DIR__."/../../../../config"]);
        $loader = new YamlFileLoader($fileLocator);
        $routes = $loader->load('routes.yaml');
        $container = require __DIR__."/../../../../src/container.php" ;
        $container->get('logger')->warning('EVENT LISTENNER FOR THIS USER > '.$user->getUsername() );

    }
}