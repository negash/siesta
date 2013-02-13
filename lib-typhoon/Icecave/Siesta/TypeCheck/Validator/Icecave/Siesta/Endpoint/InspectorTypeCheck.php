<?php
namespace Icecave\Siesta\TypeCheck\Validator\Icecave\Siesta\Endpoint;

class InspectorTypeCheck extends \Icecave\Siesta\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function inspect(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('endpoint', 0, 'ReflectionClass');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

    public function inspectIndexMethod(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('method', 0, 'ReflectionMethod');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

    public function inspectMethod(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('method', 0, 'ReflectionMethod|null');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('matchParameters', 1, 'array');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
        if ($argumentCount > 2) {
            $value = $arguments[2];
            if (!\is_bool($value)) {
                throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'allowOptionalParameters',
                    2,
                    $arguments[2],
                    'boolean'
                );
            }
        }
    }

    public function matchParameters(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('method', 0, 'ReflectionMethod');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('matchParameters', 1, 'array');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function getMethod(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('endpoint', 0, 'ReflectionClass');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('method', 1, 'string');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[1];
        if (!\is_string($value)) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                'method',
                1,
                $arguments[1],
                'string'
            );
        }
    }

}
