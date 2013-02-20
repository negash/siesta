<?php
namespace Icecave\Siesta\TypeCheck\Validator\Icecave\Siesta\Encoding;

class EncodingSelectorTypeCheck extends \Icecave\Siesta\TypeCheck\AbstractValidator
{
    public function select(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('request', 0, 'Symfony\\Component\\HttpFoundation\\Request');
            }
            throw new \Icecave\Siesta\TypeCheck\Exception\MissingArgumentException('encodingOptions', 1, 'array<Icecave\\Siesta\\Encoding\\EncodingInterface>');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[1];
        $check = function ($value) {
            if (!\is_array($value)) {
                return false;
            }
            foreach ($value as $key => $subValue) {
                if (!$subValue instanceof \Icecave\Siesta\Encoding\EncodingInterface) {
                    return false;
                }
            }
            return true;
        };
        if (!$check($arguments[1])) {
            throw new \Icecave\Siesta\TypeCheck\Exception\UnexpectedArgumentValueException(
                'encodingOptions',
                1,
                $arguments[1],
                'array<Icecave\\Siesta\\Encoding\\EncodingInterface>'
            );
        }
    }

}
