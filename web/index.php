<?php
require_once ("../vendor/autoload.php");
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals();
$application = new Mikroking\Application();
$application
    ->setDispatcher(require(__DIR__."/../app/router.php"))
    ->setContainer(require(__DIR__."/../app/container.php"));

$response = $application->handle($request);

$emiter = new Zend\Diactoros\Response\SapiEmitter();
$emiter->emit($response);
