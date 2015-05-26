<?php
namespace App\Controller;

use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class HelloController
{
    public function hello($name)
    {
        $response = new Response();
        $response->getBody()->write("hello $name");
        return $response;
    }
}
