<?php
namespace Icecave\Siesta\Router;

use Icecave\Siesta\Endpoint\Parameter;
use PHPUnit_Framework_TestCase;

class RouteTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_routingParameters = array(new Parameter('routing'));
        $this->_identityParameters = array(new Parameter('identity'));

        $this->_route = new Route(
            '/foo/:bar',
            '|^/foo/([^/]+)$|',
            $this->_routingParameters,
            $this->_identityParameters
        );
    }

    public function testIdentity()
    {
        $route = new Route('/foo/:bar', '|^/foo/([^/]+)$|');
        $this->assertTrue(is_integer($route->identity()));
        $this->assertSame($this->_route->identity(), $route->identity());

        $route = new Route('/spam/:doom', '|^/spam/([^/]+)$|');
        $this->assertTrue(is_integer($route->identity()));
        $this->assertNotSame($this->_route->identity(), $route->identity());
    }

    public function testPathPattern()
    {
        $this->assertSame('/foo/:bar', $this->_route->pathPattern());
    }

    public function testRegexPattern()
    {
        $this->assertSame('|^/foo/([^/]+)$|', $this->_route->regexPattern());
    }

    public function testRoutingParameters()
    {
        $this->assertSame($this->_routingParameters, $this->_route->routingParameters());
    }

    public function testIdentityParameters()
    {
        $this->assertSame($this->_identityParameters, $this->_route->identityParameters());
    }
}
