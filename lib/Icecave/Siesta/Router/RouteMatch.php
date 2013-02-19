<?php
namespace Icecave\Siesta\Router;

use Icecave\Siesta\TypeCheck\TypeCheck;

class RouteMatch
{
    /**
     * @param RouteInterface        $route
     * @param array<string, string> $routingArguments
     * @param array<string, string> $identityArguments
     */
    public function __construct(
        RouteInterface $route,
        array $routingArguments,
        array $identityArguments
    ) {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->route = $route;
        $this->routingArguments = $routingArguments;
        $this->identityArguments = $identityArguments;
    }

    /**
     * @return Route
     */
    public function route()
    {
        $this->typeCheck->route(func_get_args());

        return $this->route;
    }

    /**
     * @return array<string, string>
     */
    public function routingArguments()
    {
        $this->typeCheck->routingArguments(func_get_args());

        return $this->routingArguments;
    }

    /**
     * @return array<string, string>
     */
    public function identityArguments()
    {
        $this->typeCheck->identityArguments(func_get_args());

        return $this->identityArguments;
    }

    private $typeCheck;
    private $route;
    private $routingArguments;
    private $identityArguments;
}
