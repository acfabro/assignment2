<?php


namespace Acfabro\Assignment2\Error;


use Throwable;

class ServerSideException extends \Exception
{
    public function __construct($message = "", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}