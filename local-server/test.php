<?php
error_reporting(-1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../test/lib/Icecave/Siesta/TestFixtures/EndpointImplementation.php';

use Icecave\Siesta\AbstractRouter;
// use Icecave\Siesta\AbstractEndpoint;
use Icecave\Siesta\TestFixtures\EndpointImplementation;
use Icecave\Siesta\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Add some basic serialization to the endpoint.
 */
class TestEndpoint extends EndpointImplementation
{
    public function __construct()
    {
        $this->filename = '/tmp/seista-endpoint-test.ser';

        if (file_exists($this->filename)) {
            list($this->nextId, $this->items) = unserialize(
                file_get_contents($this->filename)
            );
        }
    }

    public function __destruct()
    {
        file_put_contents(
            $this->filename,
            serialize(
                array($this->nextId, $this->items)
            )
        );
    }
}

class TestRouter extends AbstractRouter
{
    public function itemsRoute()
    {
        return new EndpointImplementation;
    }
}

$request = Request::createFromGlobals();
$response = new Response;
$application = new Application(new TestRouter);
$application->execute($request, $response);
$response->send();
