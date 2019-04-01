<?php

use FastRoute\RouteCollector;

session_start();
// Включать в отчет простые описания ошибок
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once 'vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', '\Controllers\TasksController::tasks');
    $r->addRoute('POST', '/newTask', '\Controllers\TasksController::newTask');

    $r->addGroup('/admin', function (FastRoute\RouteCollector $r) {
        $r->addRoute('POST', '/login', '\Controllers\UserController::login');
        $r->addRoute('GET', '/logout', '\Controllers\UserController::logout');

        if (\Models\UserModel::isAdmin()) {
            $r->addRoute('POST', '/update/{id}', '\Controllers\TasksController::updateTask');
            $r->addRoute('GET', '/finish/{id}', '\Controllers\TasksController::finishTask');
        }
    });
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        http_response_code(404);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        http_response_code(405);
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        try {
            $vars = new stdClass();
            $vars->params = $routeInfo[2] ?: [];
            $vars->request = $_REQUEST;
            $handler($vars);

        } catch (Exception $e) {
            var_dump($e);
            http_response_code(in_array(intval($e->getMessage()), [401, 404, 405, 422]) ? intval($e->getMessage()) : 500);
        }
        break;
}
