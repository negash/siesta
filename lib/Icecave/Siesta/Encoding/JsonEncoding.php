<?php
namespace Icecave\Siesta\Encoding;

use Icecave\Siesta\TypeCheck\TypeCheck;

class JsonEncoding extends AbstractEncoding
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        parent::__construct(
            array('application/json'),
            array('json')
        );
    }

    /**
     * @param string $payload
     *
     * @return mixed
     */
    protected function decodePayload($payload)
    {
        $this->typeCheck->decodePayload(func_get_args());

        return json_decode($payload, true);
    }

    /**
     * @param mixed $payload
     *
     * @return string
     */
    protected function encodePayload($payload)
    {
        $this->typeCheck->encodePayload(func_get_args());

        return json_encode($payload);
    }

    private $typeCheck;
}
