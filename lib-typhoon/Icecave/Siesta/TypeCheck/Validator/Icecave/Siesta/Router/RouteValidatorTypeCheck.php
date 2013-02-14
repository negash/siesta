<?php
namespace Icecave\Siesta\TypeCheck\Validator\Icecave\Siesta\Router;

class RouteValidatorTypeCheck extends \Icecave\Siesta\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function validate(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('route', 0, 'Icecave\\Siesta\\Router\\Route');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('signature', 1, 'Icecave\\Siesta\\Endpoint\\Signature');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function validateParameters(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('route', 0, 'Icecave\\Siesta\\Router\\Route');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('routeParameters', 1, 'array');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('signatureParameters', 2, 'array');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
    }

}
