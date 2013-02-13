<?php
namespace Icecave\Siesta;

use Eloquent\Liberator\Liberator;
use Icecave\Collections\Map;
use PHPUnit_Framework_TestCase;
use Phake;
use Symfony\Component\HttpFoundation\Request;

class RouterTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_router = new Router;
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
