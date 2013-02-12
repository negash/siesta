<?php
namespace Icecave\Siesta\Router;

use Eloquent\Liberator\Liberator;
use Icecave\Collections\Map;
use PHPUnit_Framework_TestCase;
use Phake;
use Symfony\Component\HttpFoundation\Request;

class RouterTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_endpoint = Phake::mock('Icecave\Siesta\Endpoint\EndpointInterface');

        Phake::when($this->_endpoint)
            ->accepts(Phake::anyParameters())
            ->thenReturn(true);

        $this->_router = new Router;
    }

    public function testRoute()
    {
        $this->_router->route('/foo/bar', $this->_endpoint);

        $expected = array(
            array('|^/foo/bar$|', array(), $this->_endpoint)
        );

        $this->assertSame($expected, Liberator::liberate($this->_router)->routes);
    }

    public function testResolve()
    {
        $this->_router->route('/foo/bar', $this->_endpoint);

        $request = Request::create('/foo/bar');
        $result = $this->_router->resolve($request);

        $expected = new RouteMatch($this->_endpoint, new Map);

        Phake::verify($this->_endpoint)->accepts($expected);

        $this->assertEquals($expected, $result);
    }

    public function testResolveParameters()
    {
        $this->_router->route('/foo/bar/:id', $this->_endpoint);

        $request = Request::create('/foo/bar/27');
        $result = $this->_router->resolve($request);

        $parameters = new Map;
        $parameters->set('id', '27');
        $expected = new RouteMatch($this->_endpoint, $parameters);

        Phake::verify($this->_endpoint)->accepts($expected);

        $this->assertEquals($expected, $result);
    }

    public function testResolveNoMatch()
    {
        $this->_router->route('/foo/bar', $this->_endpoint);

        $request = Request::create('/foo/spam');
        $result = $this->_router->resolve($request);

        $this->assertNull($result);
    }

    public function testResolveNotAccepted()
    {
        Phake::when($this->_endpoint)
            ->accepts(Phake::anyParameters())
            ->thenReturn(false);

        $this->_router->route('/foo/bar', $this->_endpoint);

        $request = Request::create('/foo/bar');
        $result = $this->_router->resolve($request);

        $this->assertNull($result);
    }

    /**
     * @dataProvider pathPatterns
     */
    public function testCompilePathPattern($pathPattern, $expectedRegex, $expectedNames)
    {
        list($regex, $names) = $this->_router->compilePathPattern($pathPattern);
        $this->assertSame($expectedRegex, $regex);
        $this->assertSame($expectedNames, $names);
    }

    public function pathPatterns()
    {
        return array(
            'simple'         => array('/path/to/resource',   '|^/path/to/resource$|',          array()),
            'trailing slash' => array('/path/to/resource/',  '|^/path/to/resource$|',          array()),
            'positional 1'   => array('/path/*',             '|^/path/([^/]+)$|',              array('arg0')),
            'positional 2'   => array('/path/*/*',           '|^/path/([^/]+)/([^/]+)$|',      array('arg0', 'arg1')),
            'named 1'        => array('/path/:foo',          '|^/path/([^/]+)$|',              array('foo')),
            'named 2'        => array('/path/:foo/:bar',     '|^/path/([^/]+)/([^/]+)$|',      array('foo', 'bar')),
            'optional 1'     => array('/path/:foo?',         '|^/path(?:/([^/]+))?$|',         array('foo')),
            'optional 2'     => array('/path/:foo/:bar?',    '|^/path/([^/]+)(?:/([^/]+))?$|', array('foo', 'bar')),
            'embedded'       => array('/path/:foo/resource', '|^/path/([^/]+)/resource$|',     array('foo')),
            'escaping'       => array('/path/:foo/.',        '|^/path/([^/]+)/\\.$|',          array('foo')),
        );
    }
}
