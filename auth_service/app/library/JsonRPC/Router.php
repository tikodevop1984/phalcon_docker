<?php


namespace JsonRPC;


class Router extends \Phalcon\Mvc\Router
{
    /**
     * Handles request
     * @param string $data
     * @return void
     */
    public function handle($data = null)
    {
        // Get JsonRPC request
        if ($data) {
            $request = Request::fromString($data);
        } else {
            $request = $this->getDI()->getShared('jsonrpcRequest');
        }

        // Parse method name
        $method = explode('.', $request->method);

        $controller = null;
        if (!empty($method[0])) {
            $controller = $method[0];
        }

        $action = null;
        if (!empty($method[1])) {
            $action = $method[1];
        }

        // Setup variables
        $this->_controller = $controller;
        $this->_action     = $action;
        $this->_params     = $request->params;
    }
}