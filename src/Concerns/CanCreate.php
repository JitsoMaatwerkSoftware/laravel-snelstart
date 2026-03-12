<?php

namespace Jitso\LaravelSnelstart\Concerns;

trait CanCreate
{
    public static function create(array $attributes): static
    {
        $data = static::resolveClient()->post(static::endpoint(), $attributes);

        return (new static)->fill($data)->syncOriginal()->setExists(true);
    }

    public static function firstOrCreate(array $search, array $extra = []): static
    {
        return static::buildSearchQuery($search)->firstOrCreate($extra);
    }

    public static function firstOrNew(array $search, array $extra = []): static
    {
        return static::buildSearchQuery($search)->firstOrNew($extra);
    }
}
