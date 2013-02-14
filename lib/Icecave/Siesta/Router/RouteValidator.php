<?php
namespace Icecave\Siesta\Router;

use Icecave\Siesta\TypeCheck\TypeCheck;
use Icecave\Siesta\Endpoint\Parameter;
use Icecave\Siesta\Endpoint\Signature;
use Icecave\Collections\Set;
use LogicException;

/**
 * Checks whether a route is compatible with a given endpoint signature.
 */
class RouteValidator
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
    }

    /**
     * @param Route     $route
     * @param Signature $signature
     *
     * @throws LogicException
     */
    public function validate(Route $route, Signature $signature)
    {
        $this->typeCheck->validate(func_get_args());

        $this->validateParameters($route, $route->routingParameters(), $signature->routingParameters());
        $this->validateParameters($route, $route->identityParameters(), $signature->identityParameters());
    }

    /**
     * @param Route $route
     * @param array $routeParameters
     * @param array $signatureParameters
     */
    protected function validateParameters(Route $route, array $routeParameters, array $signatureParameters)
    {
        $this->typeCheck->validateParameters(func_get_args());

        $required = new Set;
        $optional = new Set;
        foreach ($signatureParameters as $parameter) {
            if ($parameter->isRequired()) {
                $required->add($parameter->name());
            } else {
                $optional->add($parameter->name());
            }
        }

        $provided = new Set;
        foreach ($routeParameters as $parameter) {
            $provided->add($parameter->name());
        }

        $missing = $required->complement($provided);
        if (!$missing->isEmpty()) {
            throw new LogicException(
                sprintf(
                    'Route "%s" is missing required parameter(s): %s.',
                    $route->pathPattern(),
                    implode(', ', $missing->elements())
                )
            );
        }

        $supported = $required->union($optional);
        $unsupported = $provided->complement($supported);

        if (!$unsupported->isEmpty()) {
            throw new LogicException(
                sprintf(
                    'Route "%s" provides unsupported parameter(s): %s.',
                    $route->pathPattern(),
                    implode(', ', $unsupported->elements())
                )
            );
        }
    }

    private $typeCheck;
}
