<?php
namespace Icecave\Siesta;

interface EndpointInterface
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function execute(Request $request);
}
