<?php
namespace Icecave\Siesta\Encoding;

use Eloquent\Liberator\Liberator;
use PHPUnit_Framework_TestCase;
use stdClass;

class JsonEncodingTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_encoding = new JsonEncoding;
    }

    public function testConstructor()
    {
        $this->assertTrue($this->_encoding->supportsContentType('application/json'));
        $this->assertTrue($this->_encoding->supportsFileExtension('json'));
    }

    public function testDecodePayload()
    {
        $result = Liberator::liberate($this->_encoding)->decodePayload('{"foo":"bar"}');

        $expected = new stdClass;
        $expected->foo = 'bar';

        $this->assertEquals($expected, $result);
    }

    public function testEncodePayload()
    {
        $payload = new stdClass;
        $payload->foo = 'bar';

        $result = Liberator::liberate($this->_encoding)->encodePayload($payload);

        $expected = '{"foo":"bar"}';

        $this->assertEquals($expected, $result);
    }
}
