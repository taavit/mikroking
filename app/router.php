<?php

return FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/hello/{name}', ['helloworld.controller', 'hello']);
});
