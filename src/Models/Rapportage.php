<?php

namespace Jitso\LaravelSnelstart\Models;

use Illuminate\Support\Collection;
use Jitso\LaravelSnelstart\Client\SnelstartClient;

class Rapportage
{
    public static function kolommenbalans(array $query = []): Collection
    {
        $data = static::resolveClient()->get('rapportages/kolommenbalans', $query);

        return collect($data);
    }

    public static function periodebalans(array $query = []): Collection
    {
        $data = static::resolveClient()->get('rapportages/periodebalans', $query);

        return collect($data);
    }

    protected static function resolveClient(): SnelstartClient
    {
        return app(SnelstartClient::class);
    }
}
