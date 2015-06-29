<?php
namespace Mikroking\Exception;

use Zend\Diactoros\Response\HtmlResponse;

class BasicExceptionHandler implements ExceptionHandlerInterface
{
    public function handle(BaseException $exception)
    {
        return new HtmlResponse($exception->getMessage(), $exception->getCode());
    }
}
