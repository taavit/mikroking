<?php
namespace Mikroking\Exception;

class MethodNotAllowedException extends BaseException
{
    protected $allowedMethods;

    public function __construct(array $allowedMethods = [])
    {
        $this->allowedMethods = $allowedMethods;
        parent::__construct("", 405);
    }

    public function getHeaders()
    {
        return ['Allow' => implode(", ", $this->allowedMethods)];
    }
}
