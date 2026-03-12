<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Client\SnelstartClient;

class Authorization
{
    public static function hasUserAccessToAdministration(): bool
    {
        $data = static::resolveClient()->get('authorization/HasUserAccessToAdministration');

        return $data['hasAccess'] ?? false;
    }

    protected static function resolveClient(): SnelstartClient
    {
        return app(SnelstartClient::class);
    }
}
