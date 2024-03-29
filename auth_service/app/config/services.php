<?php

use JsonRPC\Request;
use Phalcon\Mvc\View\Simple as View;
use Phalcon\Mvc\Url as UrlResolver;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * Sets the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    return $view;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'dbname'   => $config->database->dbname
    ];

    $connection = new $class($params);

    return $connection;
});

/**
 * Register router
 */
$di->setShared('router', function () {
    $router = new \Phalcon\Mvc\Router();
    $router->setUriSource(
        \Phalcon\Mvc\Router::URI_SOURCE_SERVER_REQUEST_URI
    );

    return $router;
});

/**
 * Register RPC request and response
 */
$di->setShared('request', 'Phalcon\Http\Request');
$di->setShared('response', 'Phalcon\Http\Response');

$di->setShared('rpcRequest', function() {
    $request = Phalcon\DI::getDefault()->getShared('request');
    $request = JsonRPC\Request::fromArray((array)$request->getJsonRawBody());
    return $request;
});
