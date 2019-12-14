<?php

use Graze\GuzzleHttp\JsonRpc\Client;
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
 * Auth service
 */
$di->setShared('auth', function() {
    $config = $this->getConfig();

    return Client::factory($config->services->auth->host);
});
