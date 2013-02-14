<?php
namespace Icecave\Siesta\Router;

use Icecave\Siesta\Endpoint\Parameter;
use PHPUnit_Framework_TestCase;

class RouterCompilerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_compiler = new RouteCompiler;
    }

    /**
     * @dataProvider pathPatterns
     */
    public function testCompile($pathPattern, $regexPattern, $routingParameters, $identityParameters)
    {
        $route = $this->_compiler->compile($pathPattern);
        
        $this->assertInstanceOf(__NAMESPACE__ . '\Route', $route);
        $this->assertSame($pathPattern, $route->pathPattern());
        $this->assertSame($regexPattern, $route->regexPattern());

        $expectedRoutingParameters = array();
        foreach ($routingParameters as $name) {
            $expectedRoutingParameters[] = new Parameter($name);
        }

        $expectedIdentityParameters = array();
        foreach ($identityParameters as $name) {
            $expectedIdentityParameters[] = new Parameter($name, false);
        }

        $this->assertEquals($expectedRoutingParameters, $route->routingParameters());
        $this->assertEquals($expectedIdentityParameters, $route->identityParameters());
    }

    public function pathPatterns()
    {
        return array(
            'simple'         => array('/path/to/resource',   '|^/path/to/resource$|',          array(),             array()),
            'trailing slash' => array('/path/to/resource/',  '|^/path/to/resource$|',          array(),             array()),
            'named 1'        => array('/path/:foo',          '|^/path/([^/]+)$|',              array('foo'),        array()),
            'named 2'        => array('/path/:foo/:bar',     '|^/path/([^/]+)/([^/]+)$|',      array('foo', 'bar'), array()),
            'optional 1'     => array('/path/:foo?',         '|^/path(?:/([^/]+))?$|',         array(),             array('foo')),
            'optional 2'     => array('/path/:foo/:bar?',    '|^/path/([^/]+)(?:/([^/]+))?$|', array('foo'),        array('bar')),
            'embedded'       => array('/path/:foo/resource', '|^/path/([^/]+)/resource$|',     array('foo'),        array()),
            'escaping'       => array('/path/:foo/.',        '|^/path/([^/]+)/\\.$|',          array('foo'),        array()),
        );
    }
}
