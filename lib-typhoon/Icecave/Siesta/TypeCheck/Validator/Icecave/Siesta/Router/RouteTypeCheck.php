<?php
namespace Icecave\Siesta\TypeCheck\Validator\Icecave\Siesta\Router;

class RouteTypeCheck extends \Icecave\Siesta\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('pathPattern', 0, 'string');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('regexPattern', 1, 'string');
        } elseif ($argumentCount > 4) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(4, $arguments[4]);
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
        if ($argumentCount > 2) {
            $value = $arguments[2];
            $check = function ($value) {
                if (!\is_array($value)) {
                    return false;
                }
                foreach ($value as $key => $subValue) {
                    if (!$subValue instanceof \Icecave\Siesta\Endpoint\Parameter) {
                        return false;
                    }
                }
                return true;
            };
            if (!$check($arguments[2])) {
                throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'routingParameters',
                    2,
                    $arguments[2],
                    'array<Icecave\\Siesta\\Endpoint\\Parameter>'
                );
            }
        }
        if ($argumentCount > 3) {
            $value = $arguments[3];
            $check = function ($value) {
                if (!\is_array($value)) {
                    return false;
                }
                foreach ($value as $key => $subValue) {
                    if (!$subValue instanceof \Icecave\Siesta\Endpoint\Parameter) {
                        return false;
                    }
                }
                return true;
            };
            if (!$check($arguments[3])) {
                throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'identityParameters',
                    3,
                    $arguments[3],
                    'array<Icecave\\Siesta\\Endpoint\\Parameter>'
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
