<?php
namespace Icecave\Siesta\Router;

use Symfony\Component\HttpFoundation\Request;

interface RouterInterface
{
    /**
     * @param Request $request
     *
     * @return RouteMatch|null
     */
    public function resolve(Request $request);

    /**
     * @param RouteInterface $route
     */
    public function addRoute(RouteInterface $route);

    /**
     * @param RouteInterface $route
     *
     * @return boolean
     */
    public function removeRoute(RouteInterface $route);
}
