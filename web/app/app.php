<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

//Login form
$app->get('/', function () {
    echo $this['view']->render('form', ['form' => $this->forms->get('login')]);
});


//Login handler
$app->post('/login', function(){
    $postData = $this->request->getPost();
    $form = $this->forms->get('login');

    if (!$form->isValid($postData)) {
        $messages = $form->getMessages();

        $response = '';
        foreach ($messages as $message) {
            $response .= $message . '<br>';
        }
        return $response;
    }

    $postData['password'] = md5($postData['password']);
    $authService = $this->di->getShared('auth');
    $request = $authService->request(rand(0, 100), 'login', $postData);
    try {
        $response = $authService->send($request);
        $result = $response->getRpcResult();
        if (!$result) {
            return "неверный логин или пароль";
        }

        return "успешная авторизация";
    } catch (\Throwable $e) {
        return "Что-то пошло не так";
    }
});

$app->notFound(function () use($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});
