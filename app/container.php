<?php
$di = new Pimple\Container();

$di['helloworld.controller'] = function () {
    return new App\Controller\HelloController();
};

return $di;
