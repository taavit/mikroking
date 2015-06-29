<?php
$di = new Pimple\Container();

$di['helloworld.controller'] = function () {
    return new App\Controller\HelloController();
};

$di['app.dispatcher'] = function () {
    return require(__DIR__."/router.php");
};

$di['app.controller_handler'] = function () use ($di) {
    return new Mikroking\Controller\BasicControllerHandler($di);
};

$di['app.exception_handler'] = function () {
    return new Mikroking\Exception\BasicExceptionHandler();
};

$di['app'] = function () use ($di) {
    return (new Mikroking\Application())
        ->setDispatcher($di['app.dispatcher'])
        ->setContainer($di)
        ->setControllerHandler($di['app.controller_handler'])
        ->setExceptionHandler($di['app.exception_handler']);
};

return $di;
