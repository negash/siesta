<?php
namespace Icecave\Siesta\Router;

use Icecave\Collections\Map;
use Icecave\Siesta\Endpoint\EndpointInterface;
use Icecave\Siesta\TypeCheck\TypeCheck;

class RouteMatch
{
    /**
     * @param EndpointInterface $endpoint
     * @param Map               $parameters
     */
    public function __construct(EndpointInterface $endpoint, Map $parameters)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->endpoint = $endpoint;
        $this->parameters = $parameters;
    }

    /**
     * @return EndpointInterface
     */
    public function endpoint()
    {
        $this->typeCheck->endpoint(func_get_args());

        return $this->endpoint;
    }

    /**
     * @return Map
     */
    public function parameters()
    {
        $this->typeCheck->parameters(func_get_args());

        return $this->parameters;
    }

    private $typeCheck;
    private $endpoint;
    private $parameters;
}
