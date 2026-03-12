<?php

namespace Jitso\LaravelSnelstart\Concerns;

trait CanUpsert
{
    public static function updateOrCreate(array $search, array $update = []): static
    {
        return static::buildSearchQuery($search)->updateOrCreate($update);
    }
}
