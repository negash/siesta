<?php
namespace Icecave\Siesta\Endpoint;

use Icecave\Evoke\Invoker;
use Icecave\Siesta\Router\RouteMatch;
use Icecave\Siesta\TypeCheck\TypeCheck;
use Symfony\Component\HttpFoundation\Request;

class Endpoint implements EndpointInterface
{
    /**
     * @param object        $implementation
     * @param array<string> $identityArguments
     * @param Invoker|null  $invoker
     */
    public function __construct($implementation, array $identityArguments, Invoker $invoker = null)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        if (null === $invoker) {
            $invoker = new Invoker;
        }

        $this->implementation = $implementation;
        $this->identityArguments = $identityArguments;
        $this->invoker = $invoker;
    }

    /**
     * @param Request    $request
     * @param RouteMatch $routeMatch
     * @param mixed      $payload
     *
     * @return mixed
     */
    public function process(Request $request, RouteMatch $routeMatch, $payload)
    {
        $this->typeCheck->process(func_get_args());

        $methodName = strtolower($request->getMethod());

        if ('GET' === $request->getMethod() && !$this->identityProvided($routeMatch->arguments())) {
            $methodName = 'index';
        }

        if (null === $payload) {
            $arguments = $routeMatch->arguments();
        } else {
            $arguments = array_merge($payload, $routeMatch->arguments());
        }

        if (!method_exists($this->implementation, $methodName)) {
            // TODO fix!
            throw new \Exception('Does not support ' . $methodName . '().');
        }

        return $this->invoker->invoke(
            array($this->implementation, $methodName),
            $arguments
        );
    }

    /**
     * @param array $arguments
     */
    protected function identityProvided(array $arguments)
    {
        $this->typeCheck->identityProvided(func_get_args());

        if (0 === count($this->identityArguments)) {
            return false;
        }

        foreach ($this->identityArguments as $parameterName) {
            if (!array_key_exists($parameterName, $arguments)) {
                return false;
            }
        }

        return true;
    }

    private $typeCheck;
    private $implementation;
    private $identityParameters;
    private $invoker;
}
