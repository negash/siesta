<?php
namespace Icecave\Siesta\Encoding;

use PHPUnit_Framework_TestCase;
use Phake;

class AbstractEncodingTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_contentTypes = array('application/foo', 'application/bar');
        $this->_fileExtensions = array('foo', 'bar');
        $this->_encoding = Phake::partialMock(
            __NAMESPACE__ . '\AbstractEncoding',
            $this->_contentTypes,
            $this->_fileExtensions
        );
    }

    public function testSupportsContentType()
    {
        $this->assertTrue($this->_encoding->supportsContentType('application/foo'));
        $this->assertTrue($this->_encoding->supportsContentType('application/bar'));
        $this->assertFalse($this->_encoding->supportsContentType('application/qux'));
    }

    public function testSupportsFileExtension()
    {
        $this->assertTrue($this->_encoding->supportsFileExtension('foo'));
        $this->assertTrue($this->_encoding->supportsFileExtension('bar'));
        $this->assertFalse($this->_encoding->supportsFileExtension('qux'));
    }

    public function testSupportsRequest()
    {
        $request = Phake::mock('Symfony\Component\HttpFoundation\Request');
        $this->assertFalse($this->_encoding->supportsRequest($request));
    }
}
