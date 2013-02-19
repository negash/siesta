<?php
namespace Icecave\Siesta\Router;

use Icecave\Siesta\TypeCheck\TypeCheck;

class Route implements RouteInterface
{
    /**
     * @param string        $pathPattern
     * @param string        $regexPattern
     * @param object        $endpoint
     * @param array<string> $routingParameters
     * @param array<string> $identityParameters
     */
    public function __construct($pathPattern, $regexPattern, $endpoint, array $routingParameters = array(), array $identityParameters = array())
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->pathPattern = $pathPattern;
        $this->regexPattern = $regexPattern;
        $this->endpoint = $endpoint;
        $this->routingParameters = $routingParameters;
        $this->identityParameters = $identityParameters;
    }

    /**
     * @return integer
     */
    public function identity()
    {
        $this->typeCheck->identity(func_get_args());

        return $this->regexPattern;
    }

    /**
     * @return string
     */
    public function pathPattern()
    {
        $this->typeCheck->pathPattern(func_get_args());

        return $this->pathPattern;
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
     * @param string $path
     *
     * @return RouteMatch|null
     */
    public function match($path)
    {
        $this->typeCheck->match(func_get_args());

        $matches = array();

        if (!preg_match($this->regexPattern(), $path, $matches)) {
            return null;
        }

        $routingArguments = array();
        foreach ($this->routingParameters() as $index => $name) {
            $routingArguments[$name] = $matches[$index + 1];
        }

        $identityArguments = array();
        $offset = count($this->routingParameters()) + 1;

        if (count($matches) > $offset) {
            foreach ($this->identityParameters() as $index => $name) {
                $identityArguments[$name] = $matches[$offset + $index];
            }
        }

        return new RouteMatch(
            $this,
            $routingArguments,
            $identityArguments
        );
    }

    /**
     * @return string
     */
    public function regexPattern()
    {
        $this->typeCheck->regexPattern(func_get_args());

        return $this->regexPattern;
    }

    /**
     * @return array<string>
     */
    public function routingParameters()
    {
        $this->typeCheck->routingParameters(func_get_args());

        return $this->routingParameters;
    }

    /**
     * @return array<string>
     */
    public function identityParameters()
    {
        $this->typeCheck->identityParameters(func_get_args());

        return $this->identityParameters;
    }

    private $typeCheck;
    private $pathPattern;
    private $regexPattern;
    private $endpoint;
    private $routingParameters;
    private $identityParameters;
}
