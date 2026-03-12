<?php

namespace Jitso\LaravelSnelstart\Exceptions;

use Exception;
use Illuminate\Http\Client\Response;

class SnelstartException extends Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        public readonly ?Response $response = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function fromResponse(Response $response): static
    {
        $body = $response->json() ?? [];
        $message = $body['message'] ?? $body['title'] ?? $response->reason();

        return new static(
            message: "Snelstart API error: {$message}",
            code: $response->status(),
            response: $response,
        );
    }
}
