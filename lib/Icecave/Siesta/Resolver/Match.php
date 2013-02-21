<?php
namespace Icecave\Siesta\Resolver;

use Icecave\Collections\Map;
use Icecave\Siesta\Endpoint\EndpointInterface;
use Icecave\Siesta\TypeCheck\TypeCheck;

/**
 * Represents a match between a request and endpoint.
 */
class Match
{
    /**
     * @param ResolverInterface $resolver  The resolver that made the final match.
     * @param EndpointInterface $endpoint  The endpoint the request resolved to.
     * @param Map               $arguments Arguments that were extracted from the request during resolution.
     */
    public function __construct(ResolverInterface $resolver, EndpointInterface $endpoint, Map $arguments)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->resolver = $resolver;
        $this->endpoint = $endpoint;
        $this->arguments = $arguments;
    }

    /**
     * @return ResolverInterface The resolver that made the final match.
     */
    public function resolver()
    {
        $this->typeCheck->resolver(func_get_args());

        return $this->resolver;
    }

    /**
     * @return EndpointInterface The endpoint the request resolved to.
     */
    public function endpoint()
    {
        $this->typeCheck->endpoint(func_get_args());

        return $this->endpoint;
    }

    /**
     * @return Map Arguments that were extracted from the request during resolution.
     */
    public function arguments()
    {
        $this->typeCheck->arguments(func_get_args());

        return $this->arguments;
    }

    private $typeCheck;
    private $resolver;
    private $endpoint;
    private $arguments;
}
