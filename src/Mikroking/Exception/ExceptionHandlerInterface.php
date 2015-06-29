<?php
namespace Mikroking\Exception;

interface ExceptionHandlerInterface
{
    public function handle(BaseException $exception);
}
