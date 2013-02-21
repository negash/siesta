<?php
namespace Icecave\Siesta\Resolver;

use Buzz\Message\RequestInterface;

/**
 * Resolves request objects to endpoints.
 */
interface ResolverInterface
{
    /**
     * Resolve the request to an endpoint.
     *
     * @param RequestInterface $request The request to resolve.
     *
     * @return Match|null A match describing the endpoint, or null if no match is found.
     */
    public function resolve(RequestInterface $request);
}
