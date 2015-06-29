<?php
namespace Mikroking\Controller;

use Psr\Http\Message\ServerRequestInterface;

interface ControllerHandlerInterface
{
    public function handle(array $handler, array $arguments, ServerRequestInterface $request);
}
