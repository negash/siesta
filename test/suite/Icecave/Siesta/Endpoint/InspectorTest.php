<?php
namespace Icecave\Siesta\Endpoint;

use Eloquent\Liberator\Liberator;
use Icecave\Collections\Map;
use PHPUnit_Framework_TestCase;
use Phake;
use ReflectionClass;

class RouterTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_inspector = new Inspector;
    }

    public function testInspectEmpty()
    {
        $reflector = new ReflectionClass('Icecave\Siesta\TestFixtures\Endpoint\EmptyEndpoint');

        $this->setExpectedException('InvalidArgumentException', 'EmptyEndpoint::index() does not exist.');
        $signature = $this->_inspector->inspect($reflector);
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
                array('resource' => true)
            )
        );

        $data[] = array(
            'Icecave\Siesta\TestFixtures\Endpoint\IndexOptionsEndpoint',
            new Signature(
                false,
                false,
                false,
                false,
                array('resource' => true),
                array(),
                array('option1', 'option2')
            )
        );

        $data[] = array(
            'Icecave\Siesta\TestFixtures\Endpoint\CompleteEndpoint',
            new Signature(
                true,
                true,
                true,
                true,
                array('category' => true),
                array('id'),
                array('sort', 'filter')
            )
        );

        return $data;
    }
}
