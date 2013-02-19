<?php
namespace Icecave\Siesta;

use Icecave\Collections\Vector;
use Icecave\Siesta\Encoding\EncodingSelector;
use Icecave\Siesta\Router\Router;
use Icecave\Siesta\TypeCheck\TypeCheck;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class Api
{
    /**
     * @param Router|null           $router
     * @param EncodingSelector|null $encodingSelector
     */
    public function __construct(Router $router = null, EncodingSelector $encodingSelector = null)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        if (null === $router) {
            $router = new Router;
        }

        if (null === $encodingSelector) {
            $encodingSelector = new EncodingSelector;
        }

        $this->router = $router;
        $this->encodingOptions = new Vector;
        $this->encodingSelector = $encodingSelector;
        $this->isConfigured = false;
    }

    /**
     * @param Router $router
     * @param Vector $encodingOptions
     */
    abstract public function configure(Router $router, Vector $encodingOptions);

    /**
     * @param Request  $request
     * @param Response $response
     */
    public function process(Request $request, Response $response)
    {
        $this->typeCheck->process(func_get_args());

        if (!$this->isConfigured) {
            $this->configure($this->router, $this->encodingOptions);
            $this->isConfigured = true;
        }

        if ($routeMatch = $this->router->resolve($request)) {
            $encoding = $this->encodingSelector->select($request, $this->encodingOptions);
            $inputPayload = $encoding->readRequest($request);
            $outputPayload = $routeMatch->endpoint()->process($request, $routeMatch, $inputPayload);
            $encoding->writeResponse($request, $response, $outputPayload);
        } else {
            $this->errorResponse($response, 404, 'Not Found');
        }
    }

    private $typeCheck;
    private $router;
    private $encodingOptions;
    private $encodingSelector;
    private $isConfigured;
}
