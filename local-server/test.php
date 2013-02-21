<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../test/lib/Icecave/Siesta/TestFixtures/EndpointImplementation.php';

use Icecave\Siesta\Api;
use Icecave\Siesta\Encoding\JsonEncoding;
use Icecave\Siesta\TestFixtures\EndpointImplementation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ApiVersion1 implements ApiInterface
{
    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function configure(DefinitionInterface $def)
    {
        $def->setMajorVersion(1);

        $def->add('/:owner/:id?', $this->endpoint);
    }

    private $endpoint;
}












$filename = '/tmp/siesta-endpoint-test.ser';
$endpoint = unserialize(file_get_contents($filename));
if (!$endpoint instanceof EndpointImplementation) {
    $endpoint = new EndpointImplementation;
}

$request = Request::createFromGlobals();
$response = new Response;

$api = new Api;
$api->add(new ApiVersion1($endpoint));
$api->process($request, $response);

$response->send();

file_put_contents($filename, serialize($endpoint));
