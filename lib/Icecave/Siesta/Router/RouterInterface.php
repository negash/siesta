<?php
namespace Icecave\Siesta\Router;

interface RouterInterface
{
    /**
     * @param string $path
     *
     * @return RouteMatch|null
     */
    public function resolve($path);

    /**
     * @param string  $pathPattern
     * @param object  $endpoint
     * @param boolean $allowReplace
     *
     * @return RouteInterface
     */
    public function mount($pathPattern, $endpoint, $allowReplace = false);

    /**
     * @param string $pathPattern
     *
     * @return RouteInterface|null
     */
    public function unmount($pathPattern);
}
