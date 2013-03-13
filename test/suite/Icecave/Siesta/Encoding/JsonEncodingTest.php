<?php
namespace Icecave\Siesta\Encoding;

use PHPUnit_Framework_TestCase;

class JsonEncodingTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_encoding = new JsonEncoding;
    }

    public function testCanonicalContentType()
    {
        $this->assertSame('application/json', $this->_encoding->canonicalContentType());
    }

    public function testSupportsContentType()
    {
        $this->assertTrue($this->_encoding->supportsContentType('application/json'));
    }

    public function testDecodePayload()
    {
        $payload = '{"foo":"bar"}';
        $result = $this->_encoding->decodePayload($payload);
        $expected = array('foo' => 'bar');

        $this->assertSame($expected, $result);
    }

    public function testEncodePayload()
    {
        $payload = array('foo' => 'bar');
        $result = $this->_encoding->encodePayload($payload);
        $expected = '{"foo":"bar"}';

        $this->assertSame($expected, $result);
    }
}
