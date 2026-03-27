<?php

namespace Jitso\LaravelSnelstart\Exceptions;

use Illuminate\Http\Client\Response;

class ValidationException extends SnelstartException
{
    private const BODY_SNIPPET_MAX = 1500;

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
        $errors = $body['errors'] ?? [];

        $message = self::extractPrimaryMessage($body, $response);

        return new static(
            message: "Snelstart validation error: {$message}",
            code: $response->status(),
            response: $response,
            errors: is_array($errors) ? $errors : [],
        );
    }

    /**
     * @param  array<string, mixed>  $body
     */
    private static function extractPrimaryMessage(array $body, Response $response): string
    {
        $candidates = [];

        foreach (['message', 'title', 'detail', 'error', 'error_description'] as $key) {
            if (! isset($body[$key])) {
                continue;
            }
            $val = $body[$key];
            if (is_string($val) && $val !== '') {
                $candidates[] = $val;
            } elseif (is_array($val)) {
                $encoded = json_encode($val, JSON_UNESCAPED_UNICODE);
                if ($encoded !== false && $encoded !== '[]') {
                    $candidates[] = $encoded;
                }
            }
        }

        $unique = array_values(array_unique($candidates));
        if ($unique !== []) {
            return implode(' — ', $unique);
        }

        $raw = trim($response->body());
        if ($raw !== '') {
            if (strlen($raw) > self::BODY_SNIPPET_MAX) {
                return substr($raw, 0, self::BODY_SNIPPET_MAX).'…';
            }

            return $raw;
        }

        return 'Validation failed';
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
