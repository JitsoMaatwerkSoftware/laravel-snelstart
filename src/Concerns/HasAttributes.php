<?php

namespace Jitso\LaravelSnelstart\Concerns;

use Illuminate\Support\Collection;
use Jitso\LaravelSnelstart\DataObjects\DataObject;

trait HasAttributes
{
    protected array $attributes = [];

    protected array $original = [];

    /** @var string[] Fields that can be set on this model. Empty means all fields allowed. */
    protected static array $fillable = [];

    /** @var string[] Fields required when creating this model. */
    protected static array $required = [];

    /** @var array<string, class-string<DataObject>|array{class-string<DataObject>}> */
    protected static array $casts = [];

    public function getAttribute(string $key): mixed
    {
        $value = $this->attributes[$key] ?? null;

        if ($value !== null && is_array($value) && isset(static::$casts[$key])) {
            return $this->castAttribute(static::$casts[$key], $value);
        }

        return $value;
    }

    public function setAttribute(string $key, mixed $value): static
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function fill(array $attributes): static
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    public function syncOriginal(): static
    {
        $this->original = $this->attributes;

        return $this;
    }

    public function getDirty(): array
    {
        $dirty = [];

        foreach ($this->attributes as $key => $value) {
            if (! array_key_exists($key, $this->original) || $this->original[$key] !== $value) {
                $dirty[$key] = $value;
            }
        }

        return $dirty;
    }

    public function isDirty(?string $key = null): bool
    {
        if ($key !== null) {
            return array_key_exists($key, $this->getDirty());
        }

        return count($this->getDirty()) > 0;
    }

    public function toArray(): array
    {
        return array_map(function ($value) {
            if ($value instanceof DataObject) {
                return $value->toArray();
            }
            if ($value instanceof Collection) {
                return $value->map(fn ($item) => $item instanceof DataObject ? $item->toArray() : $item)->all();
            }

            return $value;
        }, $this->attributes);
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function __get(string $key): mixed
    {
        return $this->getAttribute($key);
    }

    public function __set(string $key, mixed $value): void
    {
        $this->setAttribute($key, $value);
    }

    public function __isset(string $key): bool
    {
        return isset($this->attributes[$key]);
    }

    public function __unset(string $key): void
    {
        unset($this->attributes[$key]);
    }

    /**
     * @param class-string<DataObject>|array{class-string<DataObject>} $cast
     */
    protected function castAttribute(string|array $cast, array $value): mixed
    {
        if (is_array($cast)) {
            $class = $cast[0];

            return collect($class::collection($value));
        }

        return $cast::fromArray($value);
    }

    protected static function guardFillable(array $attributes): void
    {
        if (empty(static::$fillable)) {
            return;
        }

        $unknown = array_diff(array_keys($attributes), static::$fillable);

        if (! empty($unknown)) {
            throw \Jitso\LaravelSnelstart\Exceptions\ValidationException::unknownFields(
                class_basename(static::class),
                array_values($unknown),
            );
        }
    }

    protected static function guardRequired(array $attributes): void
    {
        if (empty(static::$required)) {
            return;
        }

        $missing = array_diff(static::$required, array_keys($attributes));

        if (! empty($missing)) {
            throw \Jitso\LaravelSnelstart\Exceptions\ValidationException::missingRequired(
                class_basename(static::class),
                array_values($missing),
            );
        }
    }
}
