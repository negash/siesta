<?php
namespace Icecave\Siesta\Endpoint;

use Icecave\Siesta\TypeCheck\TypeCheck;

/**
 * Describes the interface of an endpoint.
 */
class Signature
{
    /**
     * @param boolean                   $hasGetMethod       True if the endpoint supports provides the HTTP GET method; otherwise, false.
     * @param boolean                   $hasPostMethod      True if the endpoint supports provides the HTTP POST method; otherwise, false.
     * @param boolean                   $hasPutMethod       True if the endpoint supports provides the HTTP PUT method; otherwise, false.
     * @param boolean                   $hasDeleteMethod    True if the endpoint supports provides the HTTP DELETE method; otherwise, false.
     * @param array<string, boolean>    $routingParameters  A map of the parameters common to all methods to a boolean indicating whether or not the parameter is a required.
     * @param array<string>             $identityParameters The names parameters required to unique identify a resource (ie, id, name, etc).
     * @param array<string>             $indexOptions       The names of optional parameters to the endpoint's index method.
     * @param array<string, boolean>    $postParameters     A map of POST parameter names to a boolean indicating whether or not the parameter is a required.
     * @param array<string, boolean>    $putParameters      A map of PUT parameter names to a boolean indicating whether or not the parameter is a required.
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
     * @return array<string, boolean>
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

    /**
     * @return array<string, boolean>
     */
    public function indexOptions()
    {
        $this->typeCheck->indexOptions(func_get_args());

        return $this->indexOptions;
    }

    /**
     * @return array<string, boolean>
     */
    public function postParameters()
    {
        $this->typeCheck->postParameters(func_get_args());

        return $this->postParameters;
    }

    /**
     * @return array<string, boolean>
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
