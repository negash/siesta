<?php
namespace Icecave\Siesta\Router;

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
    public function testCompile($pathPattern, $expectedRegex, $expectedNames)
    {
        list($regex, $names) = $this->_compiler->compile($pathPattern);
        $this->assertSame($expectedRegex, $regex);
        $this->assertSame($expectedNames, $names);
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
