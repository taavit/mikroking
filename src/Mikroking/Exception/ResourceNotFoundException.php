<?php
namespace Mikroking\Exception;

class ResourceNotFoundException extends BaseException
{
    public function __construct($resource)
    {
        parent::__construct(sprintf("Resource %s not found!", $resource), 404);
    }
}
