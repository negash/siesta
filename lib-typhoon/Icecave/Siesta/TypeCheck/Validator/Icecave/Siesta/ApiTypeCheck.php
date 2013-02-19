<?php
namespace Icecave\Siesta\TypeCheck\Validator\Icecave\Siesta;

class ApiTypeCheck extends \Icecave\Siesta\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount > 2) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function configure(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('router', 0, 'Icecave\\Siesta\\Router\\Router');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('encodingOptions', 1, 'Icecave\\Collections\\Vector');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function process(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('request', 0, 'Symfony\\Component\\HttpFoundation\\Request');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('response', 1, 'Symfony\\Component\\HttpFoundation\\Response');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

}
