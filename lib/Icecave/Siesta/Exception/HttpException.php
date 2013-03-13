<?php
namespace Icecave\Siesta\Exception;

use Exception;

class HttpException extends Exception
{
    public function __construct($code, $reason, Exception $previous = null)
    {
        parent::__construct($reason, $code, $previous);
    }
}
