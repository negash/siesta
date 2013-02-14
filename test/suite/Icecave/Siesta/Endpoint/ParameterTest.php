<?php
namespace Icecave\Siesta\Endpoint;

use PHPUnit_Framework_TestCase;

class ParameterTest extends PHPUnit_Framework_TestCase
{
    public function testParameter()
    {
        $parameter = new Parameter('name');
        $this->assertSame('name', $parameter->name());
        $this->assertTrue($parameter->isRequired());

        $parameter = new Parameter('name', false);
        $this->assertSame('name', $parameter->name());
        $this->assertFalse($parameter->isRequired());
    }
}
