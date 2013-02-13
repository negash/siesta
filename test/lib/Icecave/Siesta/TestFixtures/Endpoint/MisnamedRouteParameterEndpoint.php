<?php
namespace Icecave\Siesta\TestFixtures\Endpoint;

interface MisnamedRouteParameterEndpoint
{
    public function index($resource);
    public function get($misnamedResource);
}
