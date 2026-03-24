<?php

namespace Jitso\LaravelSnelstart\Facades;

use Illuminate\Support\Facades\Facade;
use Jitso\LaravelSnelstart\Client\SnelstartClient;

/**
 * @method static array get(string $endpoint, array $query = [])
 * @method static string getBody(string $endpoint, array $query = [], array $headers = [])
 * @method static array post(string $endpoint, array $data = [])
 * @method static array put(string $endpoint, array $data = [])
 * @method static bool delete(string $endpoint)
 *
 * @see \Jitso\LaravelSnelstart\Client\SnelstartClient
 */
class Snelstart extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SnelstartClient::class;
    }
}
