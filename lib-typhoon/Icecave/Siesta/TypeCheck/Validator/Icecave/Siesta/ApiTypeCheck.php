<?php
namespace Icecave\Siesta\TypeCheck\Validator\Icecave\Siesta;

class ApiTypeCheck extends \Icecave\Siesta\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount > 3) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
    }

    public function router(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function addEncoding(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('encoding', 0, 'Icecave\\Siesta\\Encoding\\EncodingInterface');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

    public function route(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('pathPattern', 0, 'string');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('endpointImplementation', 1, 'object');
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
                'endpointImplementation',
                1,
                $arguments[1],
                'object'
            );
        }
    }

    public function configure(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
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

    public function errorResponse(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('response', 0, 'Symfony\\Component\\HttpFoundation\\Response');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('statusCode', 1, 'integer');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('message', 2, 'string');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                'statusCode',
                1,
                $arguments[1],
                'integer'
            );
        }
        $value = $arguments[2];
        if (!\is_string($value)) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                'message',
                2,
                $arguments[2],
                'string'
            );
        }
    }

}
