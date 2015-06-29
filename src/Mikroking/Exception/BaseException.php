<?php
namespace Mikroking\Exception;

abstract class BaseException extends \Exception
{
    public function getHeaders()
    {
        return [];
    }
}
