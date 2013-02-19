<?php
namespace Icecave\Siesta\Encoding;

use Icecave\Siesta\TypeCheck\TypeCheck;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractEncoding implements EncodingInterface
{
    /**
     * @param array<string> $contentTypes
     * @param array<string> $fileExtensions
     */
    public function __construct(array $contentTypes, array $fileExtensions)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->contentTypes = $contentTypes;
        $this->fileExtensions = $fileExtensions;
    }

    /**
     * @param string $contentType
     */
    public function supportsContentType($contentType)
    {
        $this->typeCheck->supportsContentType(func_get_args());

        return in_array($contentType, $this->contentTypes);
    }

    /**
     * @param string $fileExtension
     */
    public function supportsFileExtension($fileExtension)
    {
        $this->typeCheck->supportsFileExtension(func_get_args());

        return in_array($fileExtension, $this->fileExtensions);
    }

    /**
     * @param Request $request
     */
    public function supportsRequest(Request $request)
    {
        $this->typeCheck->supportsRequest(func_get_args());

        return false;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function readRequest(Request $request)
    {
        $this->typeCheck->readRequest(func_get_args());

        switch ($request->getMethod()) {
            case 'POST':
            case 'PUT':
                return $this->decodeRequest($request->getContent());
        }

        return null;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param mixed    $payload
     */
    public function writeResponse(Request $request, Response $response, $payload)
    {
        $this->typeCheck->writeResponse(func_get_args());

        $response->prepare($request);
        $response->headers->set('Content-Type', $this->contentTypes[0]);
        $response->setContent(
            $this->encodePayload($payload)
        );
    }

    /**
     * @param string $payload
     *
     * @return mixed
     */
    abstract protected function decodePayload($payload);

    /**
     * @param mixed $payload
     *
     * @return string
     */
    abstract protected function encodePayload($payload);

    private $typeCheck;
    private $contentTypes;
    private $fileExtensions;
}
