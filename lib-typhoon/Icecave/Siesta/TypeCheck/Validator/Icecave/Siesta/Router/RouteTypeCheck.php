<?php
namespace Icecave\Siesta\TypeCheck\Validator\Icecave\Siesta\Router;

class RouteTypeCheck extends \Icecave\Siesta\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('pathPattern', 0, 'string');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('regexPattern', 1, 'string');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('endpoint', 2, 'object');
        } elseif ($argumentCount > 5) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(5, $arguments[5]);
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
        if (!\is_string($value)) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                'regexPattern',
                1,
                $arguments[1],
                'string'
            );
        }
        $value = $arguments[2];
        if (!\is_object($value)) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                'endpoint',
                2,
                $arguments[2],
                'object'
            );
        }
        if ($argumentCount > 3) {
            $value = $arguments[3];
            $check = function ($value) {
                if (!\is_array($value)) {
                    return false;
                }
                foreach ($value as $key => $subValue) {
                    if (!\is_string($subValue)) {
                        return false;
                    }
                }
                return true;
            };
            if (!$check($arguments[3])) {
                throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'routingParameters',
                    3,
                    $arguments[3],
                    'array<string>'
                );
            }
        }
        if ($argumentCount > 4) {
            $value = $arguments[4];
            $check = function ($value) {
                if (!\is_array($value)) {
                    return false;
                }
                foreach ($value as $key => $subValue) {
                    if (!\is_string($subValue)) {
                        return false;
                    }
                }
                return true;
            };
            if (!$check($arguments[4])) {
                throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'identityParameters',
                    4,
                    $arguments[4],
                    'array<string>'
                );
            }
        }
    }

    public function identity(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function pathPattern(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function match(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('path', 0, 'string');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                'path',
                0,
                $arguments[0],
                'string'
            );
        }
    }

    public function endpoint(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function regexPattern(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function routingParameters(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function identityParameters(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

}
