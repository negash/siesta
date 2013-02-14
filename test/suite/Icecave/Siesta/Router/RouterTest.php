<?php
namespace Icecave\Siesta\Router;

use Eloquent\Liberator\Liberator;
use PHPUnit_Framework_TestCase;
use Phake;
use stdClass;

class RouterTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_compiler = Phake::mock(__NAMESPACE__ . '\RouteCompiler');
        $this->_route1 = Phake::mock(__NAMESPACE__ . '\RouteInterface');
        $this->_route2 = Phake::mock(__NAMESPACE__ . '\RouteInterface');
        $this->_router = new Router($this->_compiler);
        
        Phake::when($this->_compiler)
            ->compile(Phake::anyParameters())
            ->thenReturn($this->_route1)
            ->thenReturn($this->_route2);

        Phake::when($this->_route1)
            ->identity()
            ->thenReturn(1);

        Phake::when($this->_route2)
            ->identity()
            ->thenReturn(2);

        $this->_routes = Liberator::liberate($this->_router)->routes;
    }

    public function testConstructorDefaults()
    {
        $router = new Router;
        $router = Liberator::liberate($router);

        $this->assertInstanceOf(__NAMESPACE__ . '\RouteCompiler', $router->routeCompiler);
    }

    public function testResolve()
    {
        $routeMatch = Phake::mock(__NAMESPACE__ . '\RouteMatch');

        Phake::when($this->_route2)
            ->match('/path/to/2')
            ->thenReturn($routeMatch);

        $endpoint1 = new stdClass;
        $endpoint2 = new stdClass;

        $this->_router->mount('/path/to/1', $endpoint1);
        $this->_router->mount('/path/to/2', $endpoint2);

        $match = $this->_router->resolve('/path/to/2');

        $this->assertSame($routeMatch, $match);
    }

    public function testMount()
    {
        $endpoint = new stdClass;

        $route = $this->_router->mount('/path/to/endpoint', $endpoint);

        Phake::verify($this->_compiler)->compile('/path/to/endpoint', $endpoint);

        $this->assertSame($this->_route1, $route);
        $this->assertSame(1, $this->_routes->size());
        $this->assertTrue($this->_routes->contains($route));
    }

    public function testMountFailure()
    {
        Phake::when($this->_compiler)
            ->compile(Phake::anyParameters())
            ->thenReturn($this->_route1);

        $endpoint1 = new stdClass;
        $endpoint2 = new stdClass;

        $this->_router->mount('/path/to/endpoint', $endpoint1);

        $this->setExpectedException('InvalidArgumentException', 'There is already an endpoint mounted at "/path/to/endpoint".');
        $this->_router->mount('/path/to/endpoint', $endpoint2);
    }

    public function testMountReplace()
    {
        $endpoint1 = new stdClass;
        $endpoint2 = new stdClass;

        $this->_router->mount('/path/to/endpoint', $endpoint1);
        $route = $this->_router->mount('/path/to/endpoint', $endpoint2, true);

        $this->assertSame($this->_route2, $route);
    }

    public function testUnmount()
    {
        Phake::when($this->_route1)
            ->pathPattern()
            ->thenReturn('/path/to/endpoint');

        $endpoint = new stdClass;

        $this->_router->mount('/path/to/endpoint', $endpoint);

        $route = $this->_router->unmount('/path/to/endpoint');

        $this->assertSame($this->_route1, $route);
        $this->assertTrue($this->_routes->isEmpty());
    }

    public function testUnmountFailure()
    {
        Phake::when($this->_route1)
            ->pathPattern()
            ->thenReturn('/path/to/endpoint');

        $endpoint = new stdClass;

        $this->_router->mount('/path/to/endpoint', $endpoint);

        $route = $this->_router->unmount('/path/to/different/endpoint');

        $this->assertNull($route);
    }
}
