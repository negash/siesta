<?php
namespace Icecave\Siesta\Endpoint;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

class InspectorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_inspector = new Inspector;
    }

    /**
     * @dataProvider inspectSignatures
     */
    public function testInspect($className, Signature $expected)
    {
        $reflector = new ReflectionClass($className);
        $signature = $this->_inspector->inspect($reflector);
        $this->assertEquals($expected, $signature);
    }

    public function inspectSignatures()
    {
        $data = array();

        $data[] = array(
             'Icecave\Siesta\TestFixtures\Endpoint\IndexOnlyEndpoint',
             new Signature
         );

         $data[] = array(
             'Icecave\Siesta\TestFixtures\Endpoint\IndexParamsEndpoint',
             new Signature(
                 false,
                 false,
                 false,
                 false,
                 array(new Parameter('resource'))
             )
         );

         $data[] = array(
             'Icecave\Siesta\TestFixtures\Endpoint\IndexOptionsEndpoint',
             new Signature(
                 false,
                 false,
                 false,
                 false,
                 array(new Parameter('resource')),
                 array(),
                 array(
                     new Parameter('option1', false),
                     new Parameter('option2', false),
                 )
             )
         );

        $data[] = array(
            'Icecave\Siesta\TestFixtures\Endpoint\CompleteEndpoint',
            new Signature(
                true,
                true,
                true,
                true,
                array(new Parameter('category')),
                array(new Parameter('id')),
                array(
                    new Parameter('sort', false),
                    new Parameter('filter', false),
                ),
                array(
                    new Parameter('username'),
                    new Parameter('name'),
                    new Parameter('email'),
                ),
                array(
                    new Parameter('name', false),
                    new Parameter('email', false),
                )
            )
        );

        return $data;
    }

    public function testInspectEmptyFailure()
    {
        $reflector = new ReflectionClass('Icecave\Siesta\TestFixtures\Endpoint\EmptyEndpoint');

        $this->setExpectedException('LogicException', 'EmptyEndpoint::index() does not exist.');
        $signature = $this->_inspector->inspect($reflector);
    }

    public function testInspectOptionalIdentityParameterFailure()
    {
        $reflector = new ReflectionClass('Icecave\Siesta\TestFixtures\Endpoint\OptionalIdentityParameterEndpoint');

        $this->setExpectedException('LogicException', 'Parameter "id" of OptionalIdentityParameterEndpoint::get() must not be optional.');
        $signature = $this->_inspector->inspect($reflector);
    }

    public function testInspectMissingRouteParameterFailure()
    {
        $reflector = new ReflectionClass('Icecave\Siesta\TestFixtures\Endpoint\MissingRouteParameterEndpoint');

        $this->setExpectedException('LogicException', 'MissingRouteParameterEndpoint::get() must have at least 1 parameter(s).');
        $signature = $this->_inspector->inspect($reflector);
    }

    public function testInspectMisnamedRouteParameterFailure()
    {
        $reflector = new ReflectionClass('Icecave\Siesta\TestFixtures\Endpoint\MisnamedRouteParameterEndpoint');

        $this->setExpectedException('LogicException', 'Parameter #1 of MisnamedRouteParameterEndpoint::get() must be named "resource".');
        $signature = $this->_inspector->inspect($reflector);
    }

    public function testInspectStaticMethodFailure()
    {
        $reflector = new ReflectionClass('Icecave\Siesta\TestFixtures\Endpoint\StaticMethodEndpoint');

        $this->setExpectedException('LogicException', 'StaticMethodEndpoint::index() must not be static.');
        $signature = $this->_inspector->inspect($reflector);
    }

    public function testInspectNonPublicMethodFailure()
    {
        $reflector = new ReflectionClass('Icecave\Siesta\TestFixtures\Endpoint\NonPublicMethodEndpoint');

        $this->setExpectedException('LogicException', 'NonPublicMethodEndpoint::index() must be public.');
        $signature = $this->_inspector->inspect($reflector);
    }
}
