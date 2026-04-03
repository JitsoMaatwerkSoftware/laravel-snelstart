<?php

namespace Jitso\LaravelSnelstart;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use Jitso\LaravelSnelstart\Client\SnelstartClient;
use Jitso\LaravelSnelstart\Concerns\CanCreate;
use Jitso\LaravelSnelstart\Concerns\CanUpdate;
use Jitso\LaravelSnelstart\Concerns\HasAttributes;
use Jitso\LaravelSnelstart\Concerns\HasTimestamps;
use Jitso\LaravelSnelstart\Query\Builder;

abstract class Model implements Arrayable, ArrayAccess, Jsonable, JsonSerializable
{
    use HasAttributes;
    use HasTimestamps;

    protected static bool $supportsOData = false;

    protected string $primaryKey = 'id';

    protected bool $exists = false;

    abstract public static function endpoint(): string;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function getKey(): ?string
    {
        return $this->getAttribute($this->primaryKey);
    }

    public function getKeyName(): string
    {
        return $this->primaryKey;
    }

    public function exists(): bool
    {
        return $this->exists;
    }

    public function setExists(bool $exists): static
    {
        $this->exists = $exists;

        return $this;
    }

    public static function supportsOData(): bool
    {
        return static::$supportsOData;
    }

    public static function resolveClient(): SnelstartClient
    {
        return app(SnelstartClient::class);
    }

    public function newInstance(array $attributes = []): static
    {
        return (new static($attributes))->syncOriginal()->setExists(true);
    }

    public function save(): static
    {
        $uses = class_uses_recursive(static::class);

        if ($this->exists && isset($uses[CanUpdate::class])) {
            return $this->update();
        }

        if (! $this->exists && isset($uses[CanCreate::class])) {
            $data = static::resolveClient()->post(static::endpoint(), $this->toArray());

            return $this->fill($data)->syncOriginal()->setExists(true);
        }

        throw new \BadMethodCallException(
            static::class.' does not support '.($this->exists ? 'updating' : 'creating').'.',
        );
    }

    public function resolveODataField(string $field): string
    {
        return $field;
    }

    public static function buildSearchQuery(array $search): Builder
    {
        $builder = static::query();

        foreach ($search as $field => $value) {
            $builder->where($field, $value);
        }

        return $builder;
    }

    // ArrayAccess

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->getAttribute($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->setAttribute($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->attributes[$offset]);
    }

    // JsonSerializable

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function __toString(): string
    {
        return $this->toJson();
    }
}
