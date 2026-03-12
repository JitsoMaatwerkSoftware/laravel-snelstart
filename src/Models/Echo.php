<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Client\SnelstartClient;

class Echo
{
    public static function ping(): array
    {
        return static::resolveClient()->get('echo');
    }

    protected static function resolveClient(): SnelstartClient
    {
        return app(SnelstartClient::class);
    }
}
