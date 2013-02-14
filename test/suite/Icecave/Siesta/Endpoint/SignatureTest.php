<?php
namespace Icecave\Siesta\Endpoint;

use PHPUnit_Framework_TestCase;

class SignatureTest extends PHPUnit_Framework_TestCase
{
    public function testConstructorDefaults()
    {
        $signature = new Signature;

        $this->assertFalse($signature->hasGetMethod());
        $this->assertFalse($signature->hasPostMethod());
        $this->assertFalse($signature->hasPutMethod());
        $this->assertFalse($signature->hasDeleteMethod());
        $this->assertSame(array(), $signature->routingParameters());
        $this->assertSame(array(), $signature->identityParameters());
        $this->assertSame(array(), $signature->indexOptions());
        $this->assertSame(array(), $signature->postParameters());
        $this->assertSame(array(), $signature->putParameters());
    }

    public function testConstructor()
    {
        $routingParameters = array(new Parameter('routing'));
        $identityParameters = array(new Parameter('identity'));
        $indexOptions = array(new Parameter('index'));
        $postParameters = array(new Parameter('post'));
        $putParameters = array(new Parameter('put'));

        $signature = new Signature(false, false, false, false, $routingParameters, $identityParameters, $indexOptions, $postParameters, $putParameters);

        $this->assertFalse($signature->hasGetMethod());
        $this->assertFalse($signature->hasPostMethod());
        $this->assertFalse($signature->hasPutMethod());
        $this->assertFalse($signature->hasDeleteMethod());
        $this->assertSame($routingParameters, $signature->routingParameters());
        $this->assertSame($identityParameters, $signature->identityParameters());
        $this->assertSame($indexOptions, $signature->indexOptions());
        $this->assertSame($postParameters, $signature->postParameters());
        $this->assertSame($putParameters, $signature->putParameters());
    }

    public function testHasGetMethod()
    {
        $signature = new Signature(true);
        $this->assertTrue($signature->hasGetMethod());
        $this->assertFalse($signature->hasPostMethod());
        $this->assertFalse($signature->hasPutMethod());
        $this->assertFalse($signature->hasDeleteMethod());
    }

    public function testHasPostMethod()
    {
        $signature = new Signature(false, true);
        $this->assertFalse($signature->hasGetMethod());
        $this->assertTrue($signature->hasPostMethod());
        $this->assertFalse($signature->hasPutMethod());
        $this->assertFalse($signature->hasDeleteMethod());
    }

    public function testHasPutMethod()
    {
        $signature = new Signature(false, false, true);
        $this->assertFalse($signature->hasGetMethod());
        $this->assertFalse($signature->hasPostMethod());
        $this->assertTrue($signature->hasPutMethod());
        $this->assertFalse($signature->hasDeleteMethod());
    }

    public function testHasDeleteMethod()
    {
        $signature = new Signature(false, false, false, true);
        $this->assertFalse($signature->hasGetMethod());
        $this->assertFalse($signature->hasPostMethod());
        $this->assertFalse($signature->hasPutMethod());
        $this->assertTrue($signature->hasDeleteMethod());
    }
}
