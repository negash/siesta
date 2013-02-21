<?php
namespace Icecave\Siesta\Resolver;

use Buzz\Message\RequestInterface;
use Icecave\Collections\Map;
use Icecave\Siesta\TypeCheck\TypeCheck;

abstract class AbstractForwardingResolver implements ResolverInterface
{
    public function __construct(ResolverInterface $nextResolver)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
        $this->nextResolver = $resolver;
    }

    /**
     * @return ResolverInterface
     */
    public function nextResolver()
    {
        $this->typeCheck->nextResolver(func_get_args());

        return $this->nextResolver;
    }

    /**
     * Resolve the request to an endpoint.
     *
     * @param RequestInterface $request The request to resolve.
     *
     * @return Match|null A match describing the endpoint, or null if no match is found.
     */
    public function resolve(RequestInterface $request);
    {
        $this->typeCheck->resolve(func_get_args());

        $arguments = null;
        $newRequest = $this->prepareRequest($request, $arguments);

        if (null === $newRequest) {
            return null;
        }

        $match = $this->nextResolver()->resolve($newRequest);

        if (null === $match) {
            return null;
        }

        if (null !== $arguments) {
            $this->mergeArguments($match, $arguments);
        }

        return $match;
    }

    /**
     * @param RequestInterface $request
     * @param Map|null &$arguments
     *
     * @return RequestInterface|null
     */
    abstract protected function prepareRequest(RequestInterface $request, Map &$arguments = null);

    /**
     * @param Match $match
     * @param Map $arguments
     */
    protected function mergeArguments(Match $match, Map $arguments)
    {
        $match->arguments()->merge($arguments);
    }

    private $typeCheck;
    private $nextResolver;
}
