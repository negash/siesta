<?php
namespace Icecave\Siesta\Router;

use Icecave\Collections\Map;
use Icecave\Siesta\TypeCheck\TypeCheck;
use Symfony\Component\HttpFoundation\Request;

class Router implements RouterInterface
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->routes = new Map;
    }

    /**
     * @param Request $request
     *
     * @return RouteMatch|null
     */
    public function resolve(Request $request)
    {
        $this->typeCheck->resolve(func_get_args());

        foreach ($this->routes as $route) {
            if ($match = $route->resolve($request)) {
                return $match;
            }
        }

        return null;
    }

    /**
     * @param RouteInterface $route
     */
    public function addRoute(RouteInterface $route)
    {
        $this->typeCheck->addRoute(func_get_args());

        $this->routes[$route->identity()] = $route;
    }

    /**
     * @param RouteInterface $route
     *
     * @return boolean
     */
    public function removeRoute(RouteInterface $route)
    {
        $this->typeCheck->removeRoute(func_get_args());

        $value = null;
        if (!$this->routes->tryGet($route->identity(), $value)) {
            return false;
        } elseif ($value !== $route) {
            return false;
        }

        $this->routes->remove($route->identity());

        return true;
    }

    private $typeCheck;
    private $routes;
}
