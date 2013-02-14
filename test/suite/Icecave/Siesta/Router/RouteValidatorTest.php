<?php
namespace Icecave\Siesta\Router;

use Icecave\Siesta\Endpoint\Parameter;
use Icecave\Siesta\Endpoint\Signature;
use PHPUnit_Framework_TestCase;

class RouteValidatorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_validator = new RouteValidator;
    }

    public function testValidateEmpty()
    {
        $route = new Route('/foo/bar', '<regex>');
        $signature = new Signature;

        $this->assertNull($this->_validator->validate($route, $signature));
    }

    public function testValidateRoutingParameter()
    {
        $route = new Route(
            '/foo/bar',
            '<regex>',
            array(new Parameter('resource'))
        );

        $signature = new Signature(
            true, true, true, true,
            array(new Parameter('resource'))
        );

        $this->assertNull($this->_validator->validate($route, $signature));
    }

    public function testValidateUnorderedRoutingParameter()
    {
        $route = new Route(
            '/foo/bar',
            '<regex>',
            array(new Parameter('resource1'), new Parameter('resource2'))
        );

        $signature = new Signature(
            true, true, true, true,
            array(new Parameter('resource2'), new Parameter('resource1'))
        );

        $this->assertNull($this->_validator->validate($route, $signature));
    }

    public function testValidateOptionalRoutingParameter()
    {
        $route = new Route(
            '/foo/bar',
            '<regex>'
        );

        $signature = new Signature(
            true, true, true, true,
            array(new Parameter('resource', false))
        );

        $this->assertNull($this->_validator->validate($route, $signature));
    }

    public function testValidateMissingRoutingParameterFailure()
    {
        $route = new Route(
            '/foo/bar',
            '<regex>'
        );

        $signature = new Signature(
            true, true, true, true,
            array(new Parameter('resource'))
        );

        $this->setExpectedException('LogicException', 'Route "/foo/bar" is missing required parameter(s): resource.');
        $this->_validator->validate($route, $signature);
    }

    public function testValidateExtraRoutingParameterFailure()
    {
        $route = new Route(
            '/foo/bar',
            '<regex>',
            array(new Parameter('resource'))
        );

        $signature = new Signature;

        $this->setExpectedException('LogicException', 'Route "/foo/bar" provides unsupported parameter(s): resource.');
        $this->_validator->validate($route, $signature);
    }

    public function testValidateIdentityParameter()
    {
        $route = new Route(
            '/foo/bar',
            '<regex>',
            array(),
            array(new Parameter('id'))
        );

        $signature = new Signature(
            true, true, true, true,
            array(),
            array(new Parameter('id'))
        );

        $this->assertNull($this->_validator->validate($route, $signature));
    }

    public function testValidateOptionalIdentityParameter()
    {
        $route = new Route(
            '/foo/bar',
            '<regex>',
            array()
        );

        $signature = new Signature(
            true, true, true, true,
            array(),
            array(new Parameter('id', false))
        );

        $this->assertNull($this->_validator->validate($route, $signature));
    }

    public function testValidateMissingIdentityParameterFailure()
    {
        $route = new Route(
            '/foo/bar',
            '<regex>'
        );

        $signature = new Signature(
            true, true, true, true,
            array(),
            array(new Parameter('id'))
        );

        $this->setExpectedException('LogicException', 'Route "/foo/bar" is missing required parameter(s): id.');
        $this->_validator->validate($route, $signature);
    }

    public function testValidateExtraIdentityParameterFailure()
    {
        $route = new Route(
            '/foo/bar',
            '<regex>',
            array(),
            array(new Parameter('id'))
        );

        $signature = new Signature;

        $this->setExpectedException('LogicException', 'Route "/foo/bar" provides unsupported parameter(s): id.');
        $this->_validator->validate($route, $signature);
    }
}
