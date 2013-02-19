<?php
namespace Icecave\Siesta\Router;

use Symfony\Component\HttpFoundation\Request;

interface RouteInterface
{
    /**
     * @return string
     */
    public function identity();

    /**
     * @param Request $request
     *
     * @return RouteMatch|null
     */
    public function resolve(Request $request);
}
