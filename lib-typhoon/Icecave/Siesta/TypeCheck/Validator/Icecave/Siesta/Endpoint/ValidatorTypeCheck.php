<?php
namespace Icecave\Siesta\TypeCheck\Validator\Icecave\Siesta\Endpoint;

class ValidatorTypeCheck extends \Icecave\Siesta\TypeCheck\AbstractValidator
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
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('endpoint', 0, 'ReflectionClass');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('signature', 1, 'Icecave\\Siesta\\Endpoint\\Signature');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

}
