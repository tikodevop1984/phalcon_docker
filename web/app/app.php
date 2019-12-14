<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

//Login form
$app->get('/', function () {
    echo $this['view']->render('form');
});


//Login handler
$app->post('/login', function(){
    $postData = $this->request->getPost();

    $authService = $this->di->getShared('auth');

    $request = $authService->request(1, 'login', $postData);
    try {
        $response = $authService->send($request);
        $result = $response->getRpcResult();
        if (!$result) {
            echo "неверный логин или пароль";
        } else {
            echo "успешная авторизация";
        }
    } catch (\Throwable $e) {
        echo "Что-то пошло не так";
    }
});

$app->notFound(function () use($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});
