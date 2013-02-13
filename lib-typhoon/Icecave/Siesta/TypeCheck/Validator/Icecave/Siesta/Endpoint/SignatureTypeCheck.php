<?php
namespace Icecave\Siesta\TypeCheck\Validator\Icecave\Siesta\Endpoint;

class SignatureTypeCheck extends \Icecave\Siesta\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount > 9) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(9, $arguments[9]);
        }
        if ($argumentCount > 0) {
            $value = $arguments[0];
            if (!\is_bool($value)) {
                throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'hasGetMethod',
                    0,
                    $arguments[0],
                    'boolean'
                );
            }
        }
        if ($argumentCount > 1) {
            $value = $arguments[1];
            if (!\is_bool($value)) {
                throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'hasPostMethod',
                    1,
                    $arguments[1],
                    'boolean'
                );
            }
        }
        if ($argumentCount > 2) {
            $value = $arguments[2];
            if (!\is_bool($value)) {
                throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'hasPutMethod',
                    2,
                    $arguments[2],
                    'boolean'
                );
            }
        }
        if ($argumentCount > 3) {
            $value = $arguments[3];
            if (!\is_bool($value)) {
                throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'hasDeleteMethod',
                    3,
                    $arguments[3],
                    'boolean'
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
                    if (!\is_string($key)) {
                        return false;
                    }
                    if (!\is_bool($subValue)) {
                        return false;
                    }
                }
                return true;
            };
            if (!$check($arguments[4])) {
                throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'routingParameters',
                    4,
                    $arguments[4],
                    'array<string, boolean>'
                );
            }
        }
        if ($argumentCount > 5) {
            $value = $arguments[5];
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
            if (!$check($arguments[5])) {
                throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'identityParameters',
                    5,
                    $arguments[5],
                    'array<string>'
                );
            }
        }
        if ($argumentCount > 6) {
            $value = $arguments[6];
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
            if (!$check($arguments[6])) {
                throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'indexOptions',
                    6,
                    $arguments[6],
                    'array<string>'
                );
            }
        }
        if ($argumentCount > 7) {
            $value = $arguments[7];
            $check = function ($value) {
                if (!\is_array($value)) {
                    return false;
                }
                foreach ($value as $key => $subValue) {
                    if (!\is_string($key)) {
                        return false;
                    }
                    if (!\is_bool($subValue)) {
                        return false;
                    }
                }
                return true;
            };
            if (!$check($arguments[7])) {
                throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'postParameters',
                    7,
                    $arguments[7],
                    'array<string, boolean>'
                );
            }
        }
        if ($argumentCount > 8) {
            $value = $arguments[8];
            $check = function ($value) {
                if (!\is_array($value)) {
                    return false;
                }
                foreach ($value as $key => $subValue) {
                    if (!\is_string($key)) {
                        return false;
                    }
                    if (!\is_bool($subValue)) {
                        return false;
                    }
                }
                return true;
            };
            if (!$check($arguments[8])) {
                throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'putParameters',
                    8,
                    $arguments[8],
                    'array<string, boolean>'
                );
            }
        }
    }

    public function hasGetMethod(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function hasPostMethod(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function hasPutMethod(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function hasDeleteMethod(array $arguments)
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

    public function indexOptions(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function postParameters(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function putParameters(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

}
