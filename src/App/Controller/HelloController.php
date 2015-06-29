<?php
namespace App\Controller;

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequest;

class HelloController
{
    public function hello($name, ServerRequest $request)
    {
        $body = "hello $name";
        if (isset($request->getQueryParams()['upper'])) {
            $body = strtoupper($body);
        }
        return new HtmlResponse($body);
    }
}
