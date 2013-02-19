<?php
namespace Icecave\Siesta\Router;

use PHPUnit_Framework_TestCase;
use Phake;

class PathRouteTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_identity = '/:foo/:bar';
        $this->_pathRegex = '|^/(?P<foo>[^/]+?)/(?P<bar>[^/]+)$|';
        $this->_endpoint = Phake::mock('Icecave\Siesta\Endpoint\EndpointInterface');
        $this->_request = Phake::mock('Symfony\Component\HttpFoundation\Request');
        $this->_route = new PathRoute($this->_identity, $this->_pathRegex, $this->_endpoint);
    }

    public function testIdentity()
    {
        $this->assertSame($this->_identity, $this->_route->identity());
    }

    public function testResolve()
    {
        Phake::when($this->_request)
            ->getPathInfo()
            ->thenReturn('/one/two');

        $match = $this->_route->resolve($this->_request);

        $expected = new RouteMatch($this->_route, $this->_endpoint, array('foo' => 'one', 'bar' => 'two'));

        $this->assertEquals($expected, $match);
    }

    public function testResolveFailure()
    {
        Phake::when($this->_request)
            ->getPathInfo()
            ->thenReturn('/one');

        $this->assertNull($this->_route->resolve($this->_request));
    }
}
