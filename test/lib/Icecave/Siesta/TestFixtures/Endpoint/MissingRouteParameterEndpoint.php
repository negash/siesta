<?php
namespace Icecave\Siesta\TestFixtures\Endpoint;

interface MissingRouteParameterEndpoint
{
    public function index($resource);
    public function get();
}
