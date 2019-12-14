<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

/**
 * Add your routes here
 */
$app->post('/', function () {
    $rpc = $this->di->getShared('rpcRequest');

    if ($rpc->method != 'login') {
        throw new \JsonRPC\Exception\MethodNotFound('Method is not defined');
    }

    $login = $rpc->params->login ?? '';
    $pass = $rpc->params->password ?? '';
    $response = new \JsonRPC\Response();
    $response->id = $rpc->id;
    $user = User::findFirst([
        "login='$login' and password='$pass'"
    ]);
    if (!empty($user)) {
        $response->result = true;
        echo $response;
    } else {
        $response->result = false;
        echo $response;
    }
});

/**
 * Not found handler
 */
$app->notFound(function () use($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});
