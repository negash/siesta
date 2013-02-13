<?php
namespace Icecave\Siesta\Endpoint;

use Icecave\Siesta\TypeCheck\TypeCheck;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;

/**
 * Produce a signature from an endpoint.
 */
class Inspector
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
    }

    /**
     * @param ReflectionClass $endpoint
     *
     * @return Signature $signature
     */
    public function inspect(ReflectionClass $endpoint)
    {
        $this->typeCheck->inspect(func_get_args());

        $index  = $this->getMethod($endpoint, 'index');
        $get    = $this->getMethod($endpoint, 'get');
        $post   = $this->getMethod($endpoint, 'post');
        $put    = $this->getMethod($endpoint, 'put');
        $delete = $this->getMethod($endpoint, 'delete');

        if (null === $index) {
            throw new InvalidArgumentException($endpoint->getShortName() . '::index() does not exist.');
        }

        list($routingParameters, $indexOptions) = $this->inspectIndexMethod($index);
        $identityParameters = $this->inspectGetMethod($routingParameters, $get);

        return new Signature(
            null !== $get,
            null !== $post,
            null !== $put,
            null !== $delete,
            $routingParameters,
            $identityParameters,
            $indexOptions
        );
    }

    /**
     * @param ReflectionMethod $method
     */
    protected function inspectIndexMethod(ReflectionMethod $method)
    {
        $this->typeCheck->inspectIndexMethod(func_get_args());

        $numRequired = $method->getNumberOfRequiredParameters();

        $routingParameters = array();
        $indexOptions = array();

        foreach ($method->getParameters() as $index => $parameter) {
            if ($index < $numRequired) {
                $routingParameters[$parameter->getName()] = !$parameter->isOptional();
            } else {
                $indexOptions[] = $parameter->getName();
            }
        }

        return array($routingParameters, $indexOptions);
    }

    /**
     * @param array $routingParameters
     * @param ReflectionMethod|null $method
     */
    protected function inspectGetMethod(array $routingParameters, ReflectionMethod $method = null)
    {
        $this->typeCheck->inspectGetMethod(func_get_args());

        $identityParameters = array();

        if ($method) {
            foreach ($method->getParameters() as $parameter) {
                $identityParameters[] = $parameter->getName();
            }
            
            
            
            if ($identityParameters) 
        }

        return $identityParameters;
    }

    /**
     * @param ReflectionClass $endpoint
     * @param string $method
     */
    protected function getMethod(ReflectionClass $endpoint, $method)
    {
        $this->typeCheck->getMethod(func_get_args());

        if (!$endpoint->hasMethod($method)) {
            return null;
        }

        $method = $endpoint->getMethod($method);

        if ($method->isStatic()) {
            throw new InvalidArgumentException($endpoint->getShortName() . '::' . $method . '() must not be static.');
        } elseif (!$method->isPublic()) {
            throw new InvalidArgumentException($endpoint->getShortName() . '::' . $method . '() must be public.');
        } else {
            return $method;
        }
    }

    private $typeCheck;
}
