<?php


namespace JsonRPC\Exception;


class MethodNotFound extends \Exception
{
    protected $code = '-32601';
}