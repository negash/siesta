<?php
namespace Icecave\Siesta\TypeCheck\Validator\Icecave\Siesta\Router;

class RouterTypeCheck extends \Icecave\Siesta\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function route(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('resource', 0, 'string');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('endpoint', 1, 'Icecave\\Siesta\\Router\\EndpointInterface');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                'resource',
                0,
                $arguments[0],
                'string'
            );
        }
    }

    public function resolve(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('request', 0, 'Symfony\\Component\\HttpFoundation\\Request');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

    public function compilePathPattern(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('pathPattern', 0, 'string');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                'pathPattern',
                0,
                $arguments[0],
                'string'
            );
        }
    }

}
