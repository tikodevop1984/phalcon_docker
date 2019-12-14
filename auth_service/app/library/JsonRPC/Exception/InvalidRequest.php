<?php


namespace JsonRPC\Exception;


class InvalidRequest extends \Exception
{
    protected $code = '-32600';
}