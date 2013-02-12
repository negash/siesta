<?php
namespace Icecave\Siesta\Router;

use Icecave\Siesta\Endpoint\EndpointInterface;
use Symfony\Component\HttpFoundation\Request;

interface RouterInterface
{
    /**
     * @param string            $resource
     * @param EndpointInterface $endpoint
     */
    public function route($resource, EndpointInterface $endpoint);

    /**
     * @param Request $request
     *
     * @return EndpointInterface|null
     */
    public function resolve(Request $request);
}
