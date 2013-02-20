<?php
namespace Icecave\Siesta\Endpoint;

use Icecave\Siesta\TestFixtures\EndpointImplementation;
use PHPUnit_Framework_TestCase;
use Phake;

class EndpointTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_match = Phake::mock('Icecave\Siesta\Router\RouteMatch');
        $this->_payload = array(1, 2, 3);
        $this->_request = Phake::mock('Symfony\Component\HttpFoundation\Request');
        $this->_impl = new EndpointImplementation;
        $this->_endpoint = new Endpoint($this->_impl, array('id'));

        Phake::when($this->_request)
            ->getMethod()
            ->thenReturn('GET');

        Phake::when($this->_match)
            ->arguments()
            ->thenReturn(array('owner' => 'bob'));
    }

    public function testProcessIndexNoIdentityArguments()
    {
        $this->_endpoint = new Endpoint($this->_impl, array());

        $result = $this->_endpoint->process(
            $this->_request,
            $this->_match,
            null
        );

        $calls = array(
            array('index', array('bob'))
        );

        $this->assertSame(array(), $result);
        $this->assertSame($calls, $this->_impl->calls);
    }

    public function testProcessIndex()
    {
        $result = $this->_endpoint->process(
            $this->_request,
            $this->_match,
            null
        );

        $calls = array(
            array('index', array('bob'))
        );

        $this->assertSame(array(), $result);
        $this->assertSame($calls, $this->_impl->calls);
    }

    public function testProcessGet()
    {
        $this->_impl->post('bob', 'New item.');

        Phake::when($this->_match)
            ->arguments()
            ->thenReturn(array('owner' => 'bob', 'id' => 1));

        $result = $this->_endpoint->process(
            $this->_request,
            $this->_match,
            null
        );

        $calls = array(
            array('post', array('bob', 'New item.')),
            array('get', array('bob', 1))
        );

        $this->assertSame($this->_impl->items['bob'][1], $result);
        $this->assertSame($calls, $this->_impl->calls);
    }

    public function testProcessPost()
    {
        Phake::when($this->_request)
            ->getMethod()
            ->thenReturn('POST');

        $result = $this->_endpoint->process(
            $this->_request,
            $this->_match,
            array('description' => 'New item.')
        );

        $calls = array(
            array('post', array('bob', 'New item.'))
        );

        $this->assertSame($result, $this->_impl->items['bob'][1]);
        $this->assertSame($calls, $this->_impl->calls);
    }

    public function testProcessUnsupportedMethod()
    {
        Phake::when($this->_request)
            ->getMethod()
            ->thenReturn('HEAD');

        $this->setExpectedException('BadMethodCallException', 'EndpointImplementation does not support "head" request.');

        $this->_endpoint->process(
            $this->_request,
            $this->_match,
            null
        );
    }
}
