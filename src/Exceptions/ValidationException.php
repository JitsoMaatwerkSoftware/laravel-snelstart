<?php

namespace Jitso\LaravelSnelstart\Exceptions;

use Illuminate\Http\Client\Response;

class ValidationException extends SnelstartException
{
    /** @var array<string, string[]> */
    public readonly array $errors;

    public function __construct(string $message, int $code, ?Response $response, array $errors = [])
    {
        $this->errors = $errors;

        parent::__construct($message, $code, $response);
    }

    public static function fromResponse(Response $response): static
    {
        $body = $response->json() ?? [];
        $message = $body['message'] ?? $body['title'] ?? 'Validation failed';
        $errors = $body['errors'] ?? [];

        return new static(
            message: "Snelstart validation error: {$message}",
            code: $response->status(),
            response: $response,
            errors: $errors,
        );
    }
}
