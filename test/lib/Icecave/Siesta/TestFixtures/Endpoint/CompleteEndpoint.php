<?php
namespace Icecave\Siesta\TestFixtures\Endpoint;

interface CompleteEndpoint
{
    public function index($category, $sort = 'asc', $filter = null);
    public function get($category, $id);
    public function post($category, $name, $description);
    public function put($category, $id, $name, $description);
    public function delete($category, $id);
}
