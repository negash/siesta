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
    public function testCompile($pathPattern, $identity, $regexPattern, $identityParameters)
    {
        $result = $this->_compiler->compile($pathPattern);

        $this->assertTrue(is_array($result));
        $this->assertSame(3, count($result));

        list($i, $r, $p) = $result;

        $this->assertSame($identity, $i);
        $this->assertSame($regexPattern, $r);
        $this->assertSame($identityParameters, $p);
    }

    public function pathPatterns()
    {
        return array(
            'simple'         => array('/path/to/resource',   '/path/to/resource', '|^/path/to/resource$|',                        array()),
            'trailing slash' => array('/path/to/resource/',  '/path/to/resource', '|^/path/to/resource$|',                        array()),
            'named 1'        => array('/path/:foo',          '/path/*',           '|^/path/(?P<foo>[^/]+)$|',                     array()),
            'named 2'        => array('/path/:foo/:bar',     '/path/*/*',         '|^/path/(?P<foo>[^/]+)/(?P<bar>[^/]+)$|',      array()),
            'optional 1'     => array('/path/:foo?',         '/path/?',           '|^/path(?:/(?P<foo>[^/]+))?$|',                array('foo')),
            'optional 2'     => array('/path/:foo/:bar?',    '/path/*/?',         '|^/path/(?P<foo>[^/]+)(?:/(?P<bar>[^/]+))?$|', array('bar')),
            'embedded'       => array('/path/:foo/resource', '/path/*/resource',  '|^/path/(?P<foo>[^/]+)/resource$|',            array()),
            'escaping'       => array('/path/:foo/.',        '/path/*/.',         '|^/path/(?P<foo>[^/]+)/\\.$|',                 array()),
        );
    }
}
