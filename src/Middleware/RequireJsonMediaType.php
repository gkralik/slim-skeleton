<?php


namespace App\Middleware;


use Negotiation\Negotiator;
use Slim\Http\Request;
use Slim\Http\Response;

class RequireJsonMediaType
{
    const HTTP_415_UNSUPPORTED_MEDIA_TYPE = 415;

    protected $allowedMediaTypes = ['application/json'];

    function __invoke(Request $request, Response $response, callable $next = null)
    {
        $contentType = $request->getHeaderLine('Content-Type');
        if (!$this->checkMediaType($contentType)) {
            return $response = $this->invalidMediaTypeError($response, 'Content-Type', $contentType);
        }

        $accept = $request->getHeaderLine('Accept');
        if (!$this->checkMediaType($accept)) {
            return $response = $this->invalidMediaTypeError($response, 'Accept', $accept);
        }

        if ($next) {
            $response = $next($request, $response);
        }

        return $response;
    }

    protected function checkMediaType($value)
    {
        if (!$value) {
            return true;
        }

        $negotiator = new Negotiator();

        if (!$negotiator->getBest($value, $this->allowedMediaTypes)) {
            return false;
        }

        return true;
    }

    protected function invalidMediaTypeError(Response $response, $header, $wrongValue)
    {
        $acceptableMediaTypes = implode(', ', $this->allowedMediaTypes);

        return $response
            ->withStatus(static::HTTP_415_UNSUPPORTED_MEDIA_TYPE)
            ->withJson([
                'errors' => [
                    [
                        'status' => static::HTTP_415_UNSUPPORTED_MEDIA_TYPE,
                        'title'  => 'Unsupported media type',
                        'detail' => "Media type '$wrongValue' for header '$header' not supported. "
                            . "Expected one of: $acceptableMediaTypes",
                    ]
                ]
            ]);
    }

}