<?php

namespace Jitso\LaravelSnelstart\Client;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Jitso\LaravelSnelstart\Auth\TokenManager;
use Jitso\LaravelSnelstart\Exceptions\AuthenticationException;
use Jitso\LaravelSnelstart\Exceptions\NotFoundException;
use Jitso\LaravelSnelstart\Exceptions\SnelstartException;
use Jitso\LaravelSnelstart\Exceptions\ValidationException;

class SnelstartClient
{
    public function __construct(
        private readonly TokenManager $tokenManager,
        private readonly string $baseUrl,
        private readonly string $subscriptionKey,
    ) {}

    public function get(string $endpoint, array $query = []): array
    {
        $response = $this->request()->get($this->url($endpoint), $query);

        $this->handleErrors($response);

        return $response->json() ?? [];
    }

    public function post(string $endpoint, array $data = []): array
    {
        $response = $this->request()->post($this->url($endpoint), $data);

        $this->handleErrors($response);

        return $response->json() ?? [];
    }

    public function put(string $endpoint, array $data = []): array
    {
        $response = $this->request()->put($this->url($endpoint), $data);

        $this->handleErrors($response);

        return $response->json() ?? [];
    }

    public function delete(string $endpoint): bool
    {
        $response = $this->request()->delete($this->url($endpoint));

        $this->handleErrors($response);

        return true;
    }

    /**
     * Raw response body (e.g. PDF or XML) without forcing JSON Accept.
     *
     * @param  array<string, string>  $headers
     */
    public function getBody(string $endpoint, array $query = [], array $headers = []): string
    {
        $response = $this->plainRequest($headers)->get($this->url($endpoint), $query);

        $this->handleErrors($response);

        return $response->body();
    }

    private function request(): PendingRequest
    {
        return Http::withHeaders([
            'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
        ])->withToken($this->tokenManager->getToken())
            ->acceptJson()
            ->contentType('application/json');
    }

    /**
     * @param  array<string, string>  $headers
     */
    private function plainRequest(array $headers = []): PendingRequest
    {
        return Http::withHeaders(array_merge([
            'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
        ], $headers))
            ->withToken($this->tokenManager->getToken());
    }

    private function url(string $endpoint): string
    {
        return rtrim($this->baseUrl, '/').'/'.ltrim($endpoint, '/');
    }

    private function handleErrors(Response $response): void
    {
        if ($response->successful()) {
            return;
        }

        match ($response->status()) {
            400 => throw ValidationException::fromResponse($response),
            401, 403 => throw AuthenticationException::fromResponse($response),
            404 => throw NotFoundException::fromResponse($response),
            default => throw SnelstartException::fromResponse($response),
        };
    }
}
