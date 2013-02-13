<?php
namespace Icecave\Siesta\Endpoint;

use Icecave\Siesta\TypeCheck\TypeCheck;
use LogicException;
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
            throw new LogicException($endpoint->getShortName() . '::index() does not exist.');
        }

        list($routingParameters, $indexOptions) = $this->inspectIndexMethod($index);
        $identityParameters = $this->inspectMethod($get, $routingParameters, false);
        $postParameters = $this->inspectMethod($post, $routingParameters, true);
        $putParameters = $this->inspectMethod($put, array_merge($routingParameters, $identityParameters), true);

        return new Signature(
            null !== $get,
            null !== $post,
            null !== $put,
            null !== $delete,
            $routingParameters,
            $identityParameters,
            $indexOptions,
            $postParameters,
            $putParameters
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

        foreach ($method->getParameters() as $index => $reflectionParameter) {
            $parameter = new Parameter($reflectionParameter->getName(), !$reflectionParameter->isOptional());
            if ($index < $numRequired) {
                $routingParameters[] = $parameter;
            } else {
                $indexOptions[] = $parameter;
            }
        }

        return array($routingParameters, $indexOptions);
    }

    /**
     * @param ReflectionMethod|null $method                  The method to inspect.
     * @param array                 $matchParameters         An array of parameters that must be present as the left-most parameters of the method.
     * @param boolean               $allowOptionalParameters True if any remaining parameters may be optional.
     */
    protected function inspectMethod(ReflectionMethod $method = null, array $matchParameters, $allowOptionalParameters = true)
    {
        $this->typeCheck->inspectMethod(func_get_args());

        // Nothing to inspect ...
        if (null === $method) {
            return array();
        }

        $parameters = $this->matchParameters($method, $matchParameters);
        $result = array();

        foreach ($parameters as $parameter) {
            if ($parameter->isOptional() && !$allowOptionalParameters) {
                throw new LogicException(
                    sprintf(
                        'Parameter "%s" of %s::%s() must not be optional.',
                        $parameter->getName(),
                        $method->getDeclaringClass()->getShortName(),
                        $method->getName()
                    )
                );
            }

            $result[] = new Parameter(
                $parameter->getName(),
                !$parameter->isOptional()
            );
        }

        return $result;
    }

    /**
     * @param ReflectionMethod $method
     * @param array            $matchParameters
     *
     * @return array
     */
    protected function matchParameters(ReflectionMethod $method, array $matchParameters)
    {
        $this->typeCheck->matchParameters(func_get_args());

        $parameters = $method->getParameters();
        $numParameters = count($parameters);
        $numMatchParameters = count($matchParameters);

        if ($numParameters < $numMatchParameters) {
            throw new LogicException(
                sprintf(
                    '%s::%s() must have at least %d parameter(s).',
                    $method->getDeclaringClass()->getShortName(),
                    $method->getName(),
                    $numMatchParameters
                )
            );
        }

        foreach ($matchParameters as $index => $matchParameter) {
            $parameter = $parameters[$index];

            if ($parameter->getName() !== $matchParameter->name()) {
                throw new LogicException(
                    sprintf(
                        'Parameter #%d of %s::%s() must be named "%s".',
                        $index + 1,
                        $method->getDeclaringClass()->getShortName(),
                        $method->getName(),
                        $matchParameter->name()
                    )
                );
            }
        }

        return array_slice($parameters, $numMatchParameters);
    }

    /**
     * @param ReflectionClass $endpoint
     * @param string          $method
     */
    protected function getMethod(ReflectionClass $endpoint, $method)
    {
        $this->typeCheck->getMethod(func_get_args());

        if (!$endpoint->hasMethod($method)) {
            return null;
        }

        $method = $endpoint->getMethod($method);

        if ($method->isStatic()) {
            throw new LogicException($endpoint->getShortName() . '::' . $method->getName() . '() must not be static.');
        } elseif (!$method->isPublic()) {
            throw new LogicException($endpoint->getShortName() . '::' . $method->getName() . '() must be public.');
        } else {
            return $method;
        }
    }

    private $typeCheck;
}
