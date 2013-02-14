<?php
namespace Icecave\Siesta\TypeCheck\Validator\Icecave\Siesta\Router;

class RouterTypeCheck extends \Icecave\Siesta\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount > 3) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
    }

    public function mount(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('path', 0, 'string');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('endpoint', 1, 'object');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
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
        $value = $arguments[1];
        if (!\is_object($value)) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                'endpoint',
                1,
                $arguments[1],
                'object'
            );
        }
        if ($argumentCount > 2) {
            $value = $arguments[2];
            if (!\is_bool($value)) {
                throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'replace',
                    2,
                    $arguments[2],
                    'boolean'
                );
            }
        }
    }

    public function unmount(array $arguments)
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

}
