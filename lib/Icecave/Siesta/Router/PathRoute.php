<?php
namespace Icecave\Siesta\Router;

use Icecave\Siesta\Endpoint\EndpointInterface;
use Icecave\Siesta\TypeCheck\TypeCheck;
use Symfony\Component\HttpFoundation\Request;

class PathRoute implements RouteInterface
{
    /**
     * @param string            $identity
     * @param string            $pathRegex
     * @param EndpointInterface $endpoint
     */
    public function __construct($identity, $pathRegex, EndpointInterface $endpoint)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->identity = $identity;
        $this->pathRegex = $pathRegex;
        $this->endpoint = $endpoint;
    }

    /**
     * @return string
     */
    public function identity()
    {
        $this->typeCheck->identity(func_get_args());

        return $this->identity;
    }

    /**
     * @param Request $request
     *
     * @return RouteMatch|null
     */
    public function resolve(Request $request)
    {
        $this->typeCheck->resolve(func_get_args());

        $path = rtrim($request->getPathInfo(), '/');

        $matches = array();
        if (preg_match($this->pathRegex, $path, $matches)) {
            foreach ($matches as $key => $value) {
                if (is_integer($key)) {
                    unset($matches[$key]);
                }
            }

            return new RouteMatch($this, $this->endpoint, $matches);
        }

        return null;
    }

    private $typeCheck;
    private $identity;
    private $pathRegex;
    private $endpoint;
}
