<?php
namespace Icecave\Siesta\Router;

use Icecave\Siesta\Endpoint\Parameter;
use Icecave\Siesta\TypeCheck\TypeCheck;

class Route implements RouteInterface
{
    /**
     * @param string           $pathPattern
     * @param string           $regexPattern
     * @param array<Parameter> $routingParameters
     * @param array<Parameter> $identityParameters
     */
    public function __construct($pathPattern, $regexPattern, array $routingParameters = array(), array $identityParameters = array())
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->pathPattern = $pathPattern;
        $this->regexPattern = $regexPattern;
        $this->routingParameters = $routingParameters;
        $this->identityParameters = $identityParameters;

        if (array_key_exists($this->regexPattern, self::$identities)) {
            $this->identity = self::$identities[$this->regexPattern];
        } else {
            $this->identity = self::$identities[$this->regexPattern] = count(self::$identities) + 1;
        }
    }

    /**
     * @return integer
     */
    public function identity()
    {
        $this->typeCheck->identity(func_get_args());

        return $this->identity;
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
     * @param string $path
     *
     * @return RouteMatch|null
     */
    public function match($path)
    {
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
     * @return array<Parameter>
     */
    public function routingParameters()
    {
        $this->typeCheck->routingParameters(func_get_args());

        return $this->routingParameters;
    }

    /**
     * @return array<Parameter>
     */
    public function identityParameters()
    {
        $this->typeCheck->identityParameters(func_get_args());

        return $this->identityParameters;
    }

    private static $identities = array();
    private $typeCheck;
    private $pathPattern;
    private $regexPattern;
    private $routingParameters;
    private $identityParameters;
}
