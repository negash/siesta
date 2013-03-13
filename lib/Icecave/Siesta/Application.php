<?php
namespace Icecave\Siesta;

use Icecave\Siesta\Encoding\JsonEncoding;
use Icecave\Siesta\Encoding\EncodingSet;
use Icecave\Siesta\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Application
{
    public function __construct(RouterInterface $router, EncodingSet $encodingSet = null)
    {
        if (null === $encodingSet) {
            $encodingSet = new EncodingSet;
            $encodingSet->pushBack(new JsonEncoding);
        }

        $this->router = $router;
        $this->encodingSet = $encodingSet;
    }

    public function execute(HttpRequest $httpRequest, HttpResponse $httpResponse)
    {
        try {
            list($encoding, $contentType) = $this->selectOutputEncoding($httpRequest);
            $httpResponse->headers->set('Content-Type', $contentType);
            $httpResponse->setStatusCode(200);
            $httpResponse->setContent(
                $encoding->encodePayload($this->dispatch($httpRequest))
            );
        } catch (HttpException $e) {
            $encoding = $this->encodingSet->defaultEncoding();
            $httpResponse->headers->set('Content-Type', $encoding->contentType());
            $httpResponse->setStatusCode($e->getCode());
            $httpResponse->setContent(
                $encoding->encodePayload($this->createErrorPayload($e))
            );
        }
    }

    protected function dispatch(HttpRequest $httpRequest)
    {
        $apiRequest = $this->createApiRequest($httpRequest);
        list($endpoint, $apiRequest) = $this->router->resolve($apiRequest);
        return $endpoint->execute($apiRequest);
    }

    protected function selectInputEncoding(HttpRequest $httpRequest)
    {
        $contentType = $httpRequest->getContentType();
        $encoding = $this->encodingSet->findByContentType($contentType);

        if (null === $encoding) {
            throw new HttpException(415, 'Can not decode ' . $contentType . ' request.');
        }

        return array($encoding, $contentType);
    }

    protected function selectOutputEncoding(HttpRequest $httpRequest)
    {
        $contentTypes = $httpRequest->getAcceptableContentTypes();

        $allowDefault = empty($contentTypes);
        foreach ($contentTypes as $contentType) {
            if ($encoding = $this->encodingSet->findByContentType($contentType)) {
                return array($encoding, $contentType);
            } elseif ('*/*' === $contentType) {
                $allowDefault = true;
            }
        }

        if ($allowDefault) {
            $encoding = $this->encodingSet->defaultEncoding();
            return array($encoding, $encoding->contentType());
        }

        throw new HttpException(406, 'Unable to to produce response in any of the request content types (' . implode(', ', $contentTypes) . ').');
    }

    protected function createApiRequest(HttpRequest $httpRequest)
    {
        if ($content = $httpRequest->getContent()) {
            list($encoding, $contentType) = $this->selectInputEncoding($httpRequest);
            $payload = $encoding->decodePayload($payload);
        } else {
            $payload = null;
        }

        return new Request(
            $httpRequest->getMethod(),
            $httpRequest->getPathInfo(),
            $payload,
            $httpRequest->query->all()
        );
    }

    protected function createErrorPayload(HttpException $exception)
    {
        return array(
            'error' => array(
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            )
        );
    }

    private $router;
    private $encodingSet;
};
