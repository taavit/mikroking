<?php
require_once ("../vendor/autoload.php");
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals();
$container = require(__DIR__."/../app/container.php");

$response = $container['app']->handle($request);

$emiter = new Zend\Diactoros\Response\SapiEmitter();
$emiter->emit($response);
