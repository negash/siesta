<?php
namespace Icecave\Siesta\Resolver;

use Buzz\Message\RequestInterface;
use Icecave\Collections\Vector;
use Icecave\Siesta\TypeCheck\TypeCheck;

/**
 * Resolve by dispatching to multiple resolvers in sequence.
 */
class CascadingResolver implements ResolverInterface
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
        $this->resolvers = new Vector;
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

        foreach ($this->resolvers as $resolver) {
            if ($match = $resolver->resolve($request)) {
                return $match;
            }
        }

        return null;
    }

    /**
     * Add a resolver.
     *
     * @param ResolverInterface $resolver The resolver to add.
     */
    public function add(ResolverInterface $resolver)
    {
        $this->typeCheck->add(func_get_args());

        $this->resolvers->pushBack($resolver);
    }

    /**
     * Remove a resolver.
     *
     * @param ResolverInterface $resolver The resolver to remove.
     *
     * @return boolean True if the resolver was found and removed; otherwise, false.
     */
    public function remove(ResolverInterface $resolver)
    {
        $this->typeCheck->remove(func_get_args());

        $index = $this->resolvers->indexOf($resolver);

        if ($index === null) {
            return false;
        }

        $this->resolvers->remove($index);

        return true;
    }

    private $typeCheck;
    private $resolvers;
}
