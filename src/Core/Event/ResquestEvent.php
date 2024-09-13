<?php

namespace Core\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\Event;

class ResquestEvent extends Event
{
    private $request;

    const EVENT_NAME = "request" ;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function getRequest()
    {
        return $this->request;
    }
}