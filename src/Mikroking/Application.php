<?php
namespace Mikroking;

use Psr\Http\Message\ServerRequestInterface;

class Application
{
    protected $dispatcher;
    protected $container;

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
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                break;
            case \FastRoute\Dispatcher::FOUND:
                $response = $this->handleController($routeInfo[1], $routeInfo[2], $request);
                break;
        }
        return $response;
    }

    protected function handleController($handler, $arguments, ServerRequestInterface $request)
    {
        $reflection = new \ReflectionMethod($this->container[$handler[0]], $handler[1]);
        $parameters = [];
        foreach ($reflection->getParameters() as $parameter) {
            $parameterName = $parameter->getName();
            if ($parameter->getClass()) {
                $className = $parameter->getClass()->getName();
                if ($request instanceof $className) {
                    $parameters[] = $request;
                }
            }
            $parameters[] = isset($arguments[$parameterName]) ? $arguments[$parameterName] : null;
        }
        return $reflection->invokeArgs($this->container[$handler[0]], $parameters);
    }
}
