<?php

namespace Jitso\LaravelSnelstart\Auth;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Jitso\LaravelSnelstart\Exceptions\AuthenticationException;

class TokenManager
{
    private const CACHE_KEY = 'snelstart_oauth_token';

    private const CACHE_TTL_BUFFER_SECONDS = 60;

    public function __construct(
        private readonly string $tokenUrl,
        private readonly string $clientKey,
        private readonly ?string $clientSecret = null,
        private readonly string $authType = 'oauth',
        private readonly bool $cacheToken = true,
    ) {}

    public function getToken(): string
    {
        if ($this->cacheToken) {
            return Cache::remember(self::CACHE_KEY, $this->getCacheTtl(), fn () => $this->fetchToken());
        }

        return $this->fetchToken();
    }

    public function invalidate(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    private function fetchToken(): string
    {
        $response = Http::asForm()->post($this->tokenUrl, $this->buildTokenParams());

        if ($response->failed()) {
            throw new AuthenticationException(
                message: 'Failed to obtain Snelstart access token: '.$response->body(),
                code: $response->status(),
                response: $response,
            );
        }

        $data = $response->json();

        if (! isset($data['access_token'])) {
            throw new AuthenticationException(
                message: 'Snelstart token response did not contain an access_token',
                code: $response->status(),
                response: $response,
            );
        }

        return $data['access_token'];
    }

    private function buildTokenParams(): array
    {
        return match ($this->authType) {
            'clientkey' => [
                'grant_type' => 'clientkey',
                'clientkey' => $this->clientKey,
            ],
            default => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientKey,
                'client_secret' => $this->clientSecret,
            ],
        };
    }

    private function getCacheTtl(): int
    {
        return max(0, 3600 - self::CACHE_TTL_BUFFER_SECONDS);
    }
}
