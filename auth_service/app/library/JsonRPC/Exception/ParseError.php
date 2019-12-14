<?php


namespace JsonRPC\Exception;


class ParseError extends \Exception
{
    protected $code = '-32700';
}