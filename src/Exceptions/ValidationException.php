<?php

namespace Jitso\LaravelSnelstart\Exceptions;

use Illuminate\Http\Client\Response;

class ValidationException extends SnelstartException
{
    /** @var array<string, string[]> */
    public readonly array $errors;

    public function __construct(string $message, int $code = 0, ?Response $response = null, array $errors = [])
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

    /** @param string[] $fields */
    public static function missingRequired(string $model, array $fields): static
    {
        return new static(
            message: "{$model}: missing required fields: ".implode(', ', $fields),
            errors: array_fill_keys($fields, ['This field is required.']),
        );
    }

    /** @param string[] $fields */
    public static function unknownFields(string $model, array $fields): static
    {
        return new static(
            message: "{$model}: unknown fields: ".implode(', ', $fields),
            errors: array_fill_keys($fields, ['This field is not allowed.']),
        );
    }
}
