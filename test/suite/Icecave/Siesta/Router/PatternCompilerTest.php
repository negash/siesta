<?php
namespace Icecave\Siesta\Router;

use PHPUnit_Framework_TestCase;

class PatternCompilerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_compiler = new PatternCompiler;
    }

    /**
     * @dataProvider pathPatterns
     */
    public function testCompile($pathPattern, $regexPattern, $expectedRoutingParameters, $expectedIdentityParameters)
    {
        $result = $this->_compiler->compile($pathPattern);

        $expected = array($regexPattern, $expectedRoutingParameters, $expectedIdentityParameters);

        $this->assertSame($expected, $result);
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
