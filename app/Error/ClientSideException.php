<?php


namespace Acfabro\Assignment2\Error;


use Throwable;

class ClientSideException extends \Exception
{
    public function __construct($message = "", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}