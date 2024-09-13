<?php

namespace Core\Event;

use Symfony\Contracts\EventDispatcher\Event;

class CreateUserEvent extends Event
{

    const EVENT_NAME = "CreateUserEvent";


}