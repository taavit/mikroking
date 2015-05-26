<?php
namespace App\Controller;

use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class HelloController
{
    public function hello($name, ServerRequest $request)
    {
        $response = new Response();
        $body = "hello $name";
        if (isset($request->getQueryParams()['upper'])) {
            $body = strtoupper($body);
        }
        $response->getBody()->write($body);
        return $response;
    }
}
