<?php
namespace Icecave\Siesta\Encoding;

use Icecave\Siesta\TypeCheck\TypeCheck;
use Symfony\Component\HttpFoundation\Request;

/**
 * Chooses the best encoding to use based on the HTTP request.
 */
class EncodingSelector implements EncodingSelectorInterface
{
    /**
     * @param Request                  $request
     * @param array<EncodingInterface> $encodingOptions
     */
    public function select(Request $request, array $encodingOptions)
    {
        TypeCheck::get(__CLASS__)->select(func_get_args());

        // First check Accept headers in order of preference ...
        foreach ($request->getAcceptableContentTypes() as $contentType) {
            foreach ($encodingOptions as $encoding) {
                if ($encoding->supportsContentType($contentType)) {
                    return $encoding;
                }
            }
        }

        // Next try the file extension in the URL ...
        if ($extension = pathinfo($request->getPathInfo(), PATHINFO_EXTENSION)) {
            foreach ($encodingOptions as $encoding) {
                if ($encoding->supportsFileExtension($extension)) {
                    return $encoding;
                }
            }
        }

        // Finally ask the encoding itself ...
        foreach ($encodingOptions as $encoding) {
            if ($encoding->supportsRequest($request)) {
                return $encoding;
            }
        }

        // Fall back to the default encoding option ...
        return reset($encodingOptions);
    }
}
