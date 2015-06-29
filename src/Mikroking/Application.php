<?php
namespace Mikroking;

use Psr\Http\Message\ServerRequestInterface;

use Mikroking\Controller\ControllerHandlerInterface;
use Mikroking\Exception\ExceptionHandlerInterface;

class Application
{
    protected $dispatcher;
    protected $container;

    public function setExceptionHandler(ExceptionHandlerInterface $exceptionHandler)
    {
        $this->exceptionHandler = $exceptionHandler;
        return $this;
    }

    public function setControllerHandler(ControllerHandlerInterface $controllerHandler)
    {
        $this->controllerHandler = $controllerHandler;
        return $this;
    }

    public function setDispatcher($dispatcher)
    {
        $this->dispatcher = $dispatcher;
        return $this;
    }

    public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }

    public function handle(ServerRequestInterface $request)
    {
        $routeInfo = $this->dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());
        $response = null;
        try {
            switch ($routeInfo[0]) {
                case \FastRoute\Dispatcher::NOT_FOUND:
                    throw new \Mikroking\Exception\ResourceNotFoundException($request->getUri()->getPath());
                case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                    $allowedMethods = $routeInfo[1];
                    throw new \Mikroking\Exception\MethodNotAllowedException($allowedMethods);
                case \FastRoute\Dispatcher::FOUND:
                    $response = $this->handleController($routeInfo[1], $routeInfo[2], $request);
                    break;
            }
        } catch (\Mikroking\Exception\BaseException $exception) {
            $response = $this->handleException($exception);
        }
        return $response;
    }

    protected function handleController($handler, $arguments, ServerRequestInterface $request)
    {
        return $this->controllerHandler->handle($handler, $arguments, $request);
    }

    protected function handleException(\Mikroking\Exception\BaseException $exception)
    {
        return $this->exceptionHandler->handle($exception);
    }
}
