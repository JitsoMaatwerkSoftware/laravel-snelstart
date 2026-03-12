<?php

namespace Jitso\LaravelSnelstart\Models;

use Illuminate\Support\Collection;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

class Document extends Model
{
    use CanRead;

    public static function endpoint(): string
    {
        return 'documenten';
    }

    public static function find(string $id): static
    {
        $data = static::resolveClient()->get(static::endpoint()."/{$id}");

        return (new static)->fill($data)->syncOriginal()->setExists(true);
    }

    /** @return Collection<int, static> */
    public static function forParent(string $documentType, string $parentId): Collection
    {
        $data = static::resolveClient()->get(static::endpoint()."/{$documentType}/{$parentId}");

        return collect($data)->map(fn (array $item) => (new static)->fill($item)->syncOriginal()->setExists(true));
    }

    public static function createForType(string $documentType, array $data): static
    {
        $response = static::resolveClient()->post(static::endpoint()."/{$documentType}", $data);

        return (new static)->fill($response)->syncOriginal()->setExists(true);
    }

    public function update(array $attributes = []): static
    {
        $this->fill($attributes);
        $data = static::resolveClient()->put(static::endpoint()."/{$this->getKey()}", $this->toArray());

        return $this->fill($data)->syncOriginal();
    }

    public function delete(): bool
    {
        static::resolveClient()->delete(static::endpoint()."/{$this->getKey()}");
        $this->exists = false;

        return true;
    }
}
