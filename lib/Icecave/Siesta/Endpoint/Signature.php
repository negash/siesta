<?php
namespace Icecave\Siesta\Endpoint;

use Icecave\Siesta\TypeCheck\TypeCheck;

/**
 * Describes the interface of an endpoint.
 */
class Signature
{
    /**
     * @param boolean          $hasGetMethod       True if the endpoint supports provides the HTTP GET method; otherwise, false.
     * @param boolean          $hasPostMethod      True if the endpoint supports provides the HTTP POST method; otherwise, false.
     * @param boolean          $hasPutMethod       True if the endpoint supports provides the HTTP PUT method; otherwise, false.
     * @param boolean          $hasDeleteMethod    True if the endpoint supports provides the HTTP DELETE method; otherwise, false.
     * @param array<Parameter> $routingParameters  The required to route to the endpoint (and hence common to all methods).
     * @param array<Parameter> $identityParameters The parameters used to identify a resource.
     * @param array<Parameter> $indexOptions       Optional parameters that may be passed to index.
     * @param array<Parameter> $postParameters     Parameters for the POST method.
     * @param array<Parameter> $putParameters      Parameters for the PUT method.
     */
    public function __construct(
        $hasGetMethod = false,
        $hasPostMethod = false,
        $hasPutMethod = false,
        $hasDeleteMethod = false,
        array $routingParameters = array(),
        array $identityParameters = array(),
        array $indexOptions = array(),
        array $postParameters = array(),
        array $putParameters = array()
    ) {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->hasGetMethod = $hasGetMethod;
        $this->hasPostMethod = $hasPostMethod;
        $this->hasPutMethod = $hasPutMethod;
        $this->hasDeleteMethod = $hasDeleteMethod;
        $this->routingParameters = $routingParameters;
        $this->identityParameters = $identityParameters;
        $this->indexOptions = $indexOptions;
        $this->postParameters = $postParameters;
        $this->putParameters = $putParameters;
    }

    /**
     * @return boolean
     */
    public function hasGetMethod()
    {
        $this->typeCheck->hasGetMethod(func_get_args());

        return $this->hasGetMethod;
    }

    /**
     * @return boolean
     */
    public function hasPostMethod()
    {
        $this->typeCheck->hasPostMethod(func_get_args());

        return $this->hasPostMethod;
    }

    /**
     * @return boolean
     */
    public function hasPutMethod()
    {
        $this->typeCheck->hasPutMethod(func_get_args());

        return $this->hasPutMethod;
    }

    /**
     * @return boolean
     */
    public function hasDeleteMethod()
    {
        $this->typeCheck->hasDeleteMethod(func_get_args());

        return $this->hasDeleteMethod;
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

    /**
     * @return array<Parameter>
     */
    public function indexOptions()
    {
        $this->typeCheck->indexOptions(func_get_args());

        return $this->indexOptions;
    }

    /**
     * @return array<Parameter>
     */
    public function postParameters()
    {
        $this->typeCheck->postParameters(func_get_args());

        return $this->postParameters;
    }

    /**
     * @return array<Parameter>
     */
    public function putParameters()
    {
        $this->typeCheck->putParameters(func_get_args());

        return $this->putParameters;
    }

    private $typeCheck;
    private $supportedMethods;
    private $routingParameters;
    private $identityParameters;
    private $indexOptions;
    private $postParameters;
    private $putParameters;
}
