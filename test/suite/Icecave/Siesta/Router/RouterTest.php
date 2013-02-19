<?php
namespace Icecave\Siesta\Router;

use Eloquent\Liberator\Liberator;
use PHPUnit_Framework_TestCase;
use Phake;

class RouterTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_request = Phake::mock('Symfony\Component\HttpFoundation\Request');
        $this->_route1 = Phake::mock(__NAMESPACE__ . '\RouteInterface');
        $this->_route2 = Phake::mock(__NAMESPACE__ . '\RouteInterface');
        $this->_match = Phake::mock(__NAMESPACE__ . '\RouteMatch');

        Phake::when($this->_route1)
            ->identity()
            ->thenReturn('r1');

        Phake::when($this->_route2)
            ->identity()
            ->thenReturn('r2');

        $this->_router = new Router;
        $this->_routes = Liberator::liberate($this->_router)->routes;
    }

    public function testResolve()
    {
        Phake::when($this->_route2)
            ->resolve(Phake::anyParameters())
            ->thenReturn($this->_match);

        $this->_router->addRoute($this->_route1);
        $this->_router->addRoute($this->_route2);

        $result = $this->_router->resolve($this->_request);

        Phake::verify($this->_route2)->resolve($this->_request);

        $this->assertSame($this->_match, $result);
    }

    public function testResolveFailure()
    {
        $this->_router->addRoute($this->_route1);
        $this->_router->addRoute($this->_route2);

        $result = $this->_router->resolve($this->_request);

        Phake::verify($this->_route1)->resolve($this->_request);
        Phake::verify($this->_route2)->resolve($this->_request);

        $this->assertNull($result);
    }

    public function testAddRoute()
    {
        $this->_router->addRoute($this->_route1);
        $this->_router->addRoute($this->_route2);

        $this->assertSame(2, $this->_routes->size());
        $this->assertSame($this->_route1, $this->_routes['r1']);
        $this->assertSame($this->_route2, $this->_routes['r2']);
    }

    public function testAddRouteReplace()
    {
        Phake::when($this->_route2)
            ->identity()
            ->thenReturn('r1');

        $this->_router->addRoute($this->_route1);
        $this->_router->addRoute($this->_route2);

        $this->assertSame(1, $this->_routes->size());
        $this->assertSame($this->_route2, $this->_routes['r1']);
    }

    public function testRemoveRoute()
    {
        $this->_router->addRoute($this->_route1);
        $result = $this->_router->removeRoute($this->_route1);

        $this->assertTrue($result);
        $this->assertTrue($this->_routes->isEmpty());
    }

    public function testRemoveRouteFailure()
    {
        $result = $this->_router->removeRoute($this->_route1);

        $this->assertFalse($result);
    }

    public function testRemoveRouteFailureNotIdentical()
    {
        Phake::when($this->_route2)
            ->identity()
            ->thenReturn('r1');

        $result = $this->_router->addRoute($this->_route1);
        $result = $this->_router->removeRoute($this->_route2);

        $this->assertFalse($result);
    }
}
