<?php
namespace Icecave\Siesta\TestFixtures\Endpoint;

interface OptionalIdentityParameterEndpoint
{
    public function index($resource);
    public function get($resource, $id = null);
}
