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
        $this->_router = new Router;
        $this->_routes = Liberator::liberate($this->_router)->routes;
    }

    public function testConstructorDefaults()
    {
        $router = new Router;
        $router = Liberator::liberate($router);

        $this->assertInstanceOf(__NAMESPACE__ . '\PatternCompiler', $router->patternCompiler);
    }

    public function testResolve()
    {
        $endpoint1 = new stdClass;
        $endpoint2 = new stdClass;

        $this->_router->mount('/path/to/1', $endpoint1);
        $this->_router->mount('/path/to/2', $endpoint2);

        $match = $this->_router->resolve('/path/to/2');

        $this->assertInstanceOf(__NAMESPACE__ . '\RouteMatch', $match);
        $this->assertSame($endpoint2, $match->route()->endpoint());
    }

    public function testResolveFailure()
    {
        $match = $this->_router->resolve('/path/to/nothing');

        $this->assertNull($match);
    }


    public function testMountReplace()
    {
        $endpoint1 = new stdClass;
        $endpoint1->name = 1;
        $endpoint2 = new stdClass;
        $endpoint2->name = 2;

        $this->_router->mount('/path/to/endpoint', $endpoint1);
        $this->_router->mount('/path/to/endpoint', $endpoint2);

        $match = $this->_router->resolve('/path/to/endpoint');

        $this->assertInstanceOf(__NAMESPACE__ . '\RouteMatch', $match);
        $this->assertSame($endpoint2, $match->route()->endpoint());
    }

    public function testUnmount()
    {
        $endpoint = new stdClass;

        $mountRoute = $this->_router->mount('/path/to/endpoint', $endpoint);

        $unmountRoute = $this->_router->unmount('/path/to/endpoint');

        $this->assertSame($mountRoute, $unmountRoute);
        $this->assertTrue($this->_routes->isEmpty());
    }

    public function testUnmountFailure()
    {
        $endpoint = new stdClass;

        $this->_router->mount('/path/to/endpoint', $endpoint);

        $route = $this->_router->unmount('/path/to/different/endpoint');

        $this->assertNull($route);
    }
}
