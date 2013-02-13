<?php
namespace Icecave\Siesta\TestFixtures\Endpoint;

interface CompleteEndpoint
{
    public function index($category, $sort = 'asc', $filter = null);
    public function get($category, $id);
    public function post($category, $username, $name, $email);
    public function put($category, $id, $name = null, $email = null);
    public function delete($category, $id);
}
