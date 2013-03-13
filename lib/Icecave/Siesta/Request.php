<?php
namespace Icecave\Siesta;

class Request
{
    public function __construct($method, $path, $payload, array $options)
    {
        $this->method = $method;
        $this->path = $path;
        $this->payload = $payload;
        $this->options = $options;
    }

    public function path()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = '/' . trim($path, '/');
    }

    public function method()
    {
        return $this->method;
    }

    public function payload()
    {
        return $this->payload;
    }

    public function options()
    {
        return $this->options;
    }

    private $path;
    private $method;
    private $payload;
    private $options;
}
