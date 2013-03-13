<?php
namespace Icecave\Siesta;

interface RouterInterface
{
    /**
     * @param Request $request
     *
     * @return tuple<EndpointInterface, Request>
     */
    public function resolve(Request $request);
}
