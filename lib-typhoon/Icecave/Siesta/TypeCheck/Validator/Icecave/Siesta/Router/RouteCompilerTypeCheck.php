<?php
namespace Icecave\Siesta\TypeCheck\Validator\Icecave\Siesta\Router;

class RouteCompilerTypeCheck extends \Icecave\Siesta\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function compile(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('pathPattern', 0, 'string');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('endpoint', 1, 'object');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
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
        $value = $arguments[1];
        if (!\is_object($value)) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                'endpoint',
                1,
                $arguments[1],
                'object'
            );
        }
    }

}
