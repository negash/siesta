<?php
namespace Icecave\Siesta\Router;

use PHPUnit_Framework_TestCase;
use stdClass;

class RouterCompilerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_compiler = new RouteCompiler;
    }

    /**
     * @dataProvider pathPatterns
     */
    public function testCompile($pathPattern, $regexPattern, $expectedRoutingParameters, $expectedIdentityParameters)
    {
        $endpoint = new stdClass;

        $route = $this->_compiler->compile($pathPattern, $endpoint);

        $this->assertInstanceOf(__NAMESPACE__ . '\Route', $route);
        $this->assertSame($pathPattern, $route->pathPattern());
        $this->assertSame($regexPattern, $route->regexPattern());
        $this->assertSame($endpoint, $route->endpoint());
        $this->assertSame($expectedRoutingParameters, $route->routingParameters());
        $this->assertSame($expectedIdentityParameters, $route->identityParameters());
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
