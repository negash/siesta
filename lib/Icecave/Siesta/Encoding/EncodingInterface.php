<?php
namespace Icecave\Siesta\Encoding;

interface EncodingInterface
{
    /**
     * @return string
     */
    public function canonicalContentType();

    /**
     * @param string $contentType
     */
    public function supportsContentType($contentType);

    /**
     * @param mixed $payload
     *
     * @return string
     */
    public function encodePayload($payload);

    /**
     * @param string $content
     *
     * @return mixed
     */
    public function decodePayload($content);
}
