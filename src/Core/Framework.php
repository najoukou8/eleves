<?php

namespace Core;


use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;


class Framework
{
    private  $matcher;
    private  $controllerResolver;
    private  $argumentResolver;
    private  $dispatcher;

    public function __construct(
                                UrlMatcher $matcher,
                                ControllerResolver $controllerResolver,
                                ArgumentResolver $argumentResolver ,
                                EventDispatcher $dispatcher)
    {
        $this->matcher = $matcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
        $this->dispatcher = $dispatcher;
    }

    public function handle(Request $request )
    {
        $this->matcher->getContext()->fromRequest($request);
        $whoops = new Run;
        $whoops->allowQuit(false);
        $whoops->writeToOutput(false);
        $whoops->pushHandler(new PrettyPageHandler);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));
            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentResolver->getArguments($request, $controller);
            $response = call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $exception) {


            $response = new Response('<code>Front URL not found : </code>' , 404);


        } catch (\Exception $exception) {

            dump($exception) ;
            $response = new Response('An error occurred', 500);
        }

        $this->dispatcher->dispatch(new Event\ResponseEvent($response, $request), Event\ResponseEvent::EVENT_NAME );
        $this->dispatcher->dispatch(new Event\ResquestEvent($request), 'requestOn' );

        return $response;
    }

}