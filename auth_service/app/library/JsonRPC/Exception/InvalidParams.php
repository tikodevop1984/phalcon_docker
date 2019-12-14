<?php


namespace JsonRPC\Exception;


class InvalidParams extends \Exception
{
    protected $code = '-32602';
}