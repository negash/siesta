<?php
namespace Icecave\Siesta\Router;

use Icecave\Collections\Map;
use PHPUnit_Framework_TestCase;
use Phake;

class RouteMatchTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_endpoint = Phake::mock('Icecave\Siesta\Endpoint\EndpointInterface');
        $this->_parameters = new Map;
        $this->_match = new RouteMatch($this->_endpoint, $this->_parameters);
    }

    public function testConstructor()
    {
        $this->assertSame($this->_endpoint, $this->_match->endpoint());
        $this->assertSame($this->_parameters, $this->_match->parameters());
    }
}
