<?php

namespace Jitso\LaravelSnelstart\Concerns;

use Illuminate\Support\Collection;
use Jitso\LaravelSnelstart\Exceptions\SnelstartException;
use Jitso\LaravelSnelstart\Query\Builder;

trait HasCrud
{
    public static function all(): Collection
    {
        return static::query()->get();
    }

    public static function find(string $id): static
    {
        $data = static::resolveClient()->get(static::endpoint()."/{$id}");

        return (new static)->fill($data)->syncOriginal()->setExists(true);
    }

    public static function create(array $attributes): static
    {
        static::guardCapability('canCreate', 'create');

        $data = static::resolveClient()->post(static::endpoint(), $attributes);

        return (new static)->fill($data)->syncOriginal()->setExists(true);
    }

    public function update(array $attributes = []): static
    {
        static::guardCapability('canUpdate', 'update');

        $this->fill($attributes);
        $data = static::resolveClient()->put(static::endpoint()."/{$this->getKey()}", $this->toArray());

        return $this->fill($data)->syncOriginal();
    }

    public function delete(): bool
    {
        static::guardCapability('canDelete', 'delete');

        static::resolveClient()->delete(static::endpoint()."/{$this->getKey()}");
        $this->exists = false;

        return true;
    }

    public function save(): static
    {
        if ($this->exists) {
            return $this->update();
        }

        $data = static::resolveClient()->post(static::endpoint(), $this->toArray());

        return $this->fill($data)->syncOriginal()->setExists(true);
    }

    public static function query(): Builder
    {
        return new Builder(new static);
    }

    public static function where(string $field, mixed $operator = null, mixed $value = null): Builder
    {
        return static::query()->where($field, $operator, $value);
    }

    public static function take(int $amount): Builder
    {
        return static::query()->take($amount);
    }

    public static function skip(int $amount): Builder
    {
        return static::query()->skip($amount);
    }

    public static function filter(string $rawFilter): Builder
    {
        return static::query()->filter($rawFilter);
    }

    private static function guardCapability(string $flag, string $operation): void
    {
        if (! static::$$flag) {
            throw new SnelstartException(
                static::class." does not support the '{$operation}' operation."
            );
        }
    }
}
