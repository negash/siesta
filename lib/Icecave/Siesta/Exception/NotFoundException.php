<?php
namespace Icecave\Siesta\Exception;

use Exception;

class NotFoundException extends HttpException
{
    public function __construct(Exception $previous = null)
    {
        parent::__construct(404, 'Resource not found.', $previous);
    }
}
