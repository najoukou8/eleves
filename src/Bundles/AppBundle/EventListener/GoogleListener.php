<?php

namespace Bundles\AppBundle\EventListener;

use Core\Event\ResponseEvent;

class GoogleListener
{
    public function onResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();

        if ($response->isRedirection()
            || ($response->headers->has('Content-Type') && !str_contains($response->headers->get('Content-Type'), 'html'))
            || 'html' !== $event->getRequest()->getRequestFormat()
        ) {
            return;
        }

        $response->setContent($response->getContent().sprintf("Listenner %s",$event->getRequest()->getPathInfo() ));


        if( strpos ( $event->getRequest()->getPathInfo() , "Acme" ) !== false   ){
            $response->setContent($response->getContent().sprintf("URL %s" ,$event->getRequest()->getPathInfo() ));
        }

    }
}