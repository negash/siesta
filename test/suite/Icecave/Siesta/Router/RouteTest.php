<?php
namespace Icecave\Siesta\Router;

use PHPUnit_Framework_TestCase;
use stdClass;

class RouteTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_pathPattern = '/foo/:routing/:identity?';
        $this->_regexPattern = '|^/foo/([^/]+)(?:/([^/]+))?$|';
        $this->_endpoint = new stdClass;
        $this->_routingParameters = array('routing');
        $this->_identityParameters = array('identity');

        $this->_route = new Route(
            $this->_pathPattern,
            $this->_regexPattern,
            $this->_endpoint,
            $this->_routingParameters,
            $this->_identityParameters
        );
    }

    public function testIdentity()
    {
        $route = new Route('/foo/:bar', $this->_regexPattern, $this->_endpoint);
        $this->assertTrue(is_integer($route->identity()));
        $this->assertSame($this->_route->identity(), $route->identity());

        $route = new Route('/spam/:doom', '|^/spam/([^/]+)$|', $this->_endpoint);
        $this->assertTrue(is_integer($route->identity()));
        $this->assertNotSame($this->_route->identity(), $route->identity());
    }

    public function testPathPattern()
    {
        $this->assertSame($this->_pathPattern, $this->_route->pathPattern());
    }

    public function testRegexPattern()
    {
        $this->assertSame($this->_regexPattern, $this->_route->regexPattern());
    }

    public function testEndpoint()
    {
        $this->assertSame($this->_endpoint, $this->_route->endpoint());
    }

    public function testRoutingParameters()
    {
        $this->assertSame($this->_routingParameters, $this->_route->routingParameters());
    }

    public function testIdentityParameters()
    {
        $this->assertSame($this->_identityParameters, $this->_route->identityParameters());
    }

    public function testMatch()
    {
        $match = $this->_route->match('/foo/quux');

        $expected = new RouteMatch($this->_route, array('routing' => 'quux'), array());

        $this->assertEquals($expected, $match);
    }

    public function testMatchWithIdentity()
    {
        $match = $this->_route->match('/foo/quux/28');

        $expected = new RouteMatch($this->_route, array('routing' => 'quux'), array('identity' => '28'));

        $this->assertEquals($expected, $match);
    }

    public function testMatchFailure()
    {
        $match = $this->_route->match('/bar/quux/28');

        $this->assertNull($match);
    }
}
