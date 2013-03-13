<?php
namespace Icecave\Siesta\Encoding;

use PHPUnit_Framework_TestCase;
use Phake;

class EncodingSetTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_encoding1 = Phake::mock(__NAMESPACE__ . '\EncodingInterface');
        $this->_encoding2 = Phake::mock(__NAMESPACE__ . '\EncodingInterface');

        $this->_set = new EncodingSet;

        $this->_set->pushBack($this->_encoding1);
        $this->_set->pushBack($this->_encoding2);
    }

    public function testDefaultEncoding()
    {
        $this->assertSame($this->_encoding1, $this->_set->defaultEncoding());
    }

    public function testFindByContentType()
    {
        $jsonEncoding = new JsonEncoding;

        $this->_set->pushBack($jsonEncoding);

        $this->assertSame($jsonEncoding, $this->_set->findByContentType('application/json'));

        Phake::inOrder(
            Phake::verify($this->_encoding1)->supportsContentType('application/json'),
            Phake::verify($this->_encoding2)->supportsContentType('application/json')
        );
    }

    public function testFindByContentTypeFailure()
    {
        $this->assertNull($this->_set->findByContentType('application/json'));

        Phake::inOrder(
            Phake::verify($this->_encoding1)->supportsContentType('application/json'),
            Phake::verify($this->_encoding2)->supportsContentType('application/json')
        );
    }
}
