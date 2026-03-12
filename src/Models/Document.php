<?php

namespace Jitso\LaravelSnelstart\Models;

use Illuminate\Support\Collection;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property string|null $parentIdentifier
 * @property string|null $fileName
 * @property bool|null $readOnly
 * @property string|null $content
 * @property string|null $uri
 */
class Document extends Model
{
    use CanRead;

    protected static array $fillable = [
        'parentIdentifier',
        'fileName',
        'readOnly',
        'content',
    ];

    public static function endpoint(): string
    {
        return 'documenten';
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
