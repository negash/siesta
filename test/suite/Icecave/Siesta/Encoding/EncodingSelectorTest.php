<?php
namespace Icecave\Siesta\Encoding;

use PHPUnit_Framework_TestCase;
use Phake;

class EncodingSelectorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_encoding1 = Phake::mock(__NAMESPACE__ . '\EncodingInterface');
        $this->_encoding2 = Phake::mock(__NAMESPACE__ . '\EncodingInterface');
        $this->_encodings = array($this->_encoding1, $this->_encoding2);
        $this->_request = Phake::partialMock('Symfony\Component\HttpFoundation\Request');
        $this->_selector = new EncodingSelector;

        Phake::when($this->_request)
            ->getAcceptableContentTypes()
            ->thenReturn(array('application/foo', 'application/bar'));

        Phake::when($this->_request)
            ->getPathInfo()
            ->thenReturn('/path/to/request.bar');
    }

    public function testSelectByContentType()
    {
        Phake::when($this->_encoding2)
            ->supportsContentType('application/bar')
            ->thenReturn(true);

        $result = $this->_selector->select($this->_request, $this->_encodings);

        Phake::inOrder(
            Phake::verify($this->_request)->getAcceptableContentTypes(),
            Phake::verify($this->_encoding1)->supportsContentType('application/foo'),
            Phake::verify($this->_encoding2)->supportsContentType('application/foo'),
            Phake::verify($this->_encoding1)->supportsContentType('application/bar'),
            Phake::verify($this->_encoding2)->supportsContentType('application/bar')
        );

        $this->assertSame($this->_encoding2, $result);
    }

    public function testSelectByFileExtension()
    {
        Phake::when($this->_encoding2)
            ->supportsFileExtension('bar')
            ->thenReturn(true);

        $result = $this->_selector->select($this->_request, $this->_encodings);

        Phake::inOrder(
            Phake::verify($this->_encoding1)->supportsFileExtension('bar'),
            Phake::verify($this->_encoding2)->supportsFileExtension('bar')
        );

        $this->assertSame($this->_encoding2, $result);
    }

    public function testSelectByRequest()
    {

        Phake::when($this->_encoding2)
            ->supportsRequest($this->_request)
            ->thenReturn(true);

        $result = $this->_selector->select($this->_request, $this->_encodings);

        Phake::inOrder(
            Phake::verify($this->_encoding1)->supportsRequest($this->_request),
            Phake::verify($this->_encoding2)->supportsRequest($this->_request)
        );

        $this->assertSame($this->_encoding2, $result);
    }

    public function testSelectDefaultFallback()
    {
        $result = $this->_selector->select($this->_request, $this->_encodings);

        $this->assertSame($this->_encoding1, $result);
    }
}
