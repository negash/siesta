<?php
namespace Icecave\Siesta\Endpoint;

use ReflectionClass;

class EndpointInspector
{
    /**
     * @param EndpointInterface $endpoint
     *
     * @return EndpointTraits
     */
    public function inspect(EndpointInterface $endpoint, ReflectionClass $reflector = null)
    {
        if (null === $reflector) {
            $reflector = new ReflectionClass($endpoint);
        }
        
        $traits = new EndpointTraits;

        $index = $reflector->getMethod('index');
        foreach ($index->getParameters() as $parameter) {
            $traits->addBaseParameter($parameter->getName(), $parameter->getDefaultValue());
        }

        if ($reflector->hasMethod('get')) {
            $method = $reflector->getMethod('get');
            foreach ($index->getParameters() as $parameter) {
                
            }
        }

        var_dump(
            $get    = $reflector->getMethod('get'),
            $post   = $reflector->getMethod('post'),
            $put    = $reflector->getMethod('put'),
            $delete = $reflector->getMethod('delete')
        );
    }
}
