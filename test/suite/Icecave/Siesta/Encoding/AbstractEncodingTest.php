<?php
namespace Icecave\Siesta\Encoding;

use PHPUnit_Framework_TestCase;
use Phake;

class AbstractEncodingTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_request = Phake::partialMock('Symfony\Component\HttpFoundation\Request');
        $this->_response = Phake::partialMock('Symfony\Component\HttpFoundation\Response');

        Phake::when($this->_request)
            ->getMethod()
            ->thenReturn('GET');

        Phake::when($this->_request)
            ->getContent()
            ->thenReturn('<content>');

        $this->_contentTypes = array('application/foo', 'application/bar');
        $this->_fileExtensions = array('foo', 'bar');
        $this->_encoding = Phake::partialMock(
            __NAMESPACE__ . '\AbstractEncoding',
            $this->_contentTypes,
            $this->_fileExtensions
        );

        Phake::when($this->_encoding)
            ->decodePayload(Phake::anyParameters())
            ->thenReturn('<decoded payload>');

        Phake::when($this->_encoding)
            ->encodePayload(Phake::anyParameters())
            ->thenReturn('<encoded payload>');
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

    public function testReadRequest()
    {
        $result = $this->_encoding->readRequest($this->_request);

        Phake::verify($this->_request)->getMethod();
        Phake::verify($this->_request, Phake::never())->getContent();

        $this->assertNull($result);
    }

    /**
     * @dataProvider methodsWithPayload
     */
    public function testReadRequestWithPayload($method)
    {
        Phake::when($this->_request)
            ->getMethod()
            ->thenReturn($method);

        $result = $this->_encoding->readRequest($this->_request);

        Phake::inOrder(
            Phake::verify($this->_request)->getMethod(),
            Phake::verify($this->_request)->getContent(),
            Phake::verify($this->_encoding)->decodePayload('<content>')
        );

        $this->assertSame('<decoded payload>', $result);
    }

    public function methodsWithPayload()
    {
        return array(
            array('POST'),
            array('PUT'),
        );
    }

    public function testWriteResponse()
    {
        $this->_encoding->writeResponse($this->_request, $this->_response, '<payload>');

        Phake::inOrder(
            Phake::verify($this->_response)->prepare($this->_request),
            Phake::verify($this->_encoding)->encodePayload('<payload>'),
            Phake::verify($this->_response)->setContent('<encoded payload>')
        );

        $this->assertSame('application/foo', $this->_response->headers->get('Content-Type'));
    }
}
