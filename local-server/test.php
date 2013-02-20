<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../test/lib/Icecave/Siesta/TestFixtures/EndpointImplementation.php';

use Icecave\Collections\Vector;
use Icecave\Siesta\Api;
use Icecave\Siesta\Router\Router;
use Icecave\Siesta\Router\PathRoute;
use Icecave\Siesta\Endpoint\Endpoint;
use Icecave\Siesta\Encoding\JsonEncoding;
use Icecave\Siesta\TestFixtures\EndpointImplementation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MyApi extends Api
{
    public function configure()
    {
        $this->addEncoding(new JsonEncoding);
        $this->route('/:owner/:id?', $this->endpoint);
    }

    // Hacks to persist data for example ...
    // This is not part of the bootstrapping of an API generally.
    public function __construct($filename = '/tmp/siesta-endpoint-test.ser')
    {
        parent::__construct();

        $this->filename = $filename;
        if (file_exists($filename)) {
            $this->endpoint = unserialize(file_get_contents($filename));
        }

        if (!$this->endpoint instanceof EndpointImplementation) {
            $this->endpoint = new EndpointImplementation;
        }
    }

    public function __destruct()
    {
        if ($this->endpoint instanceof EndpointImplementation) {
            file_put_contents($this->filename, serialize($this->endpoint));
        }
    }

    private $filename;
    private $endpoint;
}



// Create API and serve request ...
$request = Request::createFromGlobals();
$response = new Response;

$api = new MyApi;
$api->process($request, $response);
$response->send();
