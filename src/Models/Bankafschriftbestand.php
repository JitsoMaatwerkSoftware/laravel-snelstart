<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Client\SnelstartClient;

class Bankafschriftbestand
{
    public static function upload(string $name, string $base64Content): array
    {
        return static::resolveClient()->post('bankafschriftbestanden', [
            'name' => $name,
            'base64EncodedContent' => $base64Content,
        ]);
    }

    protected static function resolveClient(): SnelstartClient
    {
        return app(SnelstartClient::class);
    }
}
