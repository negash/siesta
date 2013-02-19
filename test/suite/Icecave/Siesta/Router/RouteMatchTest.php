<?php
namespace Icecave\Siesta\Router;

use PHPUnit_Framework_TestCase;
use Phake;

class RouteMatchTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_route = Phake::mock(__NAMESPACE__ . '\RouteInterface');
        $this->_routingArguments = array('routing' => 'foo');
        $this->_identityArguments =  array('identity' => 'bar');
        $this->_match = new RouteMatch($this->_route, $this->_routingArguments, $this->_identityArguments);
    }

    public function testRoute()
    {
        $this->assertSame($this->_route, $this->_match->route());
    }

    public function testRoutingArguments()
    {
        $this->assertSame($this->_routingArguments, $this->_match->routingArguments());
    }

    public function testIdentityArguments()
    {
        $this->assertSame($this->_identityArguments, $this->_match->identityArguments());
    }
}
