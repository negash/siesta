<?php
namespace Icecave\Siesta\TypeCheck\Validator\Icecave\Siesta\Router;

class RouteMatchTypeCheck extends \Icecave\Siesta\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('route', 0, 'Icecave\\Siesta\\Router\\RouteInterface');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('endpoint', 1, 'Icecave\\Siesta\\Endpoint\\EndpointInterface');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('arguments', 2, 'array<string, string>');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
        $value = $arguments[2];
        $check = function ($value) {
            if (!\is_array($value)) {
                return false;
            }
            foreach ($value as $key => $subValue) {
                if (!\is_string($key)) {
                    return false;
                }
                if (!\is_string($subValue)) {
                    return false;
                }
            }
            return true;
        };
        if (!$check($arguments[2])) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                'arguments',
                2,
                $arguments[2],
                'array<string, string>'
            );
        }
    }

    public function route(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function endpoint(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function arguments(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

}
