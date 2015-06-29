<?php
namespace Mikroking\Controller;

use Psr\Http\Message\ServerRequestInterface;

class BasicControllerHandler implements ControllerHandlerInterface
{
    protected $di;

    public function __construct($di)
    {
        $this->di = $di;
    }

    public function handle(array $handler, array $arguments, ServerRequestInterface $request)
    {
        $reflection = new \ReflectionMethod($this->di[$handler[0]], $handler[1]);
        $parameters = [];
        foreach ($reflection->getParameters() as $parameter) {
            $parameterName = $parameter->name;
            if ($parameter->getClass()) {
                if ($parameter->getClass()->isInstance($request)) {
                    $parameters[] = $request;
                }
            }
            $parameters[] = isset($arguments[$parameterName]) ? $arguments[$parameterName] : null;
        }
        return $reflection->invokeArgs($this->di[$handler[0]], $parameters);
    }
}
