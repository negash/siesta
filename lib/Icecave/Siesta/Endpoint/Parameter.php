<?php
namespace Icecave\Siesta\Endpoint;

use Icecave\Siesta\TypeCheck\TypeCheck;

class Parameter
{
    /**
     * @param string  $name
     * @param boolean $isRequired
     */
    public function __construct($name, $isRequired = true)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->name = $name;
        $this->isRequired = $isRequired;
    }

    public function name()
    {
        $this->typeCheck->name(func_get_args());

        return $this->name;
    }

    public function isRequired()
    {
        $this->typeCheck->isRequired(func_get_args());

        return $this->isRequired;
    }

    private $typeCheck;
}
