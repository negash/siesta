<?php
namespace Icecave\Siesta\Router;

use Icecave\Siesta\Endpoint\EndpointInterface;
use Icecave\Siesta\TypeCheck\TypeCheck;

class RouteMatch
{
    /**
     * @param RouteInterface        $route
     * @param EndpointInterface     $endpoint
     * @param array<string, string> $arguments
     */
    public function __construct(RouteInterface $route, EndpointInterface $endpoint, array $arguments)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->route = $route;
        $this->endpoint = $endpoint;
        $this->arguments = $arguments;
    }

    public function route()
    {
        $this->typeCheck->route(func_get_args());

        return $this->route;
    }

    public function endpoint()
    {
        $this->typeCheck->endpoint(func_get_args());

        return $this->endpoint;
    }

    public function arguments()
    {
        $this->typeCheck->arguments(func_get_args());

        return $this->arguments;
    }

    private $typeCheck;
    private $route;
    private $endpoint;
    private $arguments;
}
