<?php
namespace Icecave\Siesta\Router;

use Icecave\Siesta\Endpoint\Parameter;
use Icecave\Siesta\Endpoint\Signature;
use Icecave\Siesta\TypeCheck\TypeCheck;

class RouteMatch
{
    /**
     * @param Route                 $route
     * @param object                $endpoint
     * @param Signature             $signature
     * @param array<string, string> $routingArguments
     * @param array<string, string> $identityArguments
     */
    public function __construct(
        Route $route,
        $endpoint,
        Signature $signature,
        array $routingArguments,
        array $identityArguments
    ) {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->route = $route;
        $this->endpoint = $endpoint;
        $this->signature = $signature;
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
     * @return object
     */
    public function endpoint()
    {
        $this->typeCheck->endpoint(func_get_args());

        return $this->endpoint;
    }

    /**
     * @return Signature
     */
    public function signature()
    {
        $this->typeCheck->signature(func_get_args());

        return $this->signature;
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
    private $endpoint;
    private $signature;
    private $routingArguments;
    private $identityArguments;
}
