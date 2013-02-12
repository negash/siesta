<?php
namespace Icecave\Siesta\Router;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface ExecutorInterface
{
    /** 
     * @param Request $request
     *
     * @return Response
     */
    public function execute(Request $request);
}
