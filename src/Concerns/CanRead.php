<?php

namespace Jitso\LaravelSnelstart\Concerns;

use Illuminate\Support\Collection;
use Jitso\LaravelSnelstart\Exceptions\NotFoundException;
use Jitso\LaravelSnelstart\Query\Builder;

trait CanRead
{
    /** @return Collection<int, static> */
    public static function all(): Collection
    {
        return static::query()->get();
    }

    public static function find(string $id): static
    {
        $data = static::resolveClient()->get(static::endpoint()."/{$id}");

        return (new static)->fill($data)->syncOriginal()->setExists(true);
    }

    public static function findOrNew(string $id): static
    {
        try {
            return static::find($id);
        } catch (NotFoundException) {
            return new static;
        }
    }

    /** @return Builder<static> */
    public static function query(): Builder
    {
        return new Builder(new static);
    }

    /** @return Builder<static> */
    public static function where(string $field, mixed $operator = null, mixed $value = null): Builder
    {
        return static::query()->where($field, $operator, $value);
    }

    /** @return Builder<static> */
    public static function whereInteger(string $field, int $value): Builder
    {
        return static::query()->whereInteger($field, $value);
    }

    /** @return Builder<static> */
    public static function take(int $amount): Builder
    {
        return static::query()->take($amount);
    }

    /** @return Builder<static> */
    public static function skip(int $amount): Builder
    {
        return static::query()->skip($amount);
    }

    /** @return Builder<static> */
    public static function filter(string $rawFilter): Builder
    {
        return static::query()->filter($rawFilter);
    }
}
