<?php
namespace Icecave\Siesta\TestFixtures;

use stdClass;

class EndpointImplementation
{
    public function index($owner)
    {
        $this->calls[] = array(__FUNCTION__, func_get_args());

        if (array_key_exists($owner, $this->items)) {
            return $this->items[$owner];
        }

        return array();
    }

    public function get($owner, $id)
    {
        $this->calls[] = array(__FUNCTION__, func_get_args());

        return $this->items[$owner][$id];
    }

    public function post($owner, $description)
    {
        $this->calls[] = array(__FUNCTION__, func_get_args());

        $item = new stdClass;
        $item->id = $this->nextId++;
        $item->owner = $owner;
        $item->description = $description;

        $this->items[$owner][$item->id] = $item;

        return $item;
    }

    public function put($owner, $id, $description)
    {
        $this->calls[] = array(__FUNCTION__, func_get_args());

        $item = $this->items[$owner][$id];
        $item->description = $description;

        return $item;
    }

    public function delete($owner, $id)
    {
        $this->calls[] = array(__FUNCTION__, func_get_args());

        unset($this->items[$owner][$id]);
    }

    public $nextId = 1;
    public $items = array();
    public $calls = array();
}
