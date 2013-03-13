<?php
namespace Icecave\Siesta\Router;

use PHPUnit_Framework_TestCase;
use Phake;

class RouteMatchTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_route = Phake::mock(__NAMESPACE__ . '\RouterInterface');
        $this->_endpoint = Phake::mock('Icecave\Siesta\Endpoint\EndpointInterface');
        $this->_arguments = array('foo' => 'bar');
        $this->_match = new RouteMatch($this->_route, $this->_endpoint, $this->_arguments);
    }

    public function testRoute()
    {
        $this->assertSame($this->_route, $this->_match->route());
    }

    public function testEndpoint()
    {
        $this->assertSame($this->_endpoint, $this->_match->endpoint());
    }

    public function testArguments()
    {
        $this->assertSame($this->_arguments, $this->_match->arguments());
    }
}
