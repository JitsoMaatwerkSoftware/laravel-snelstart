<?php

namespace Jitso\LaravelSnelstart\Models;

use Illuminate\Support\Collection;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Enums\DocumentParentType;
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

        return static::mapListResponse($data);
    }

    /** @return Collection<int, static> */
    public static function forParentType(DocumentParentType $type, string $parentId): Collection
    {
        return static::forParent($type->value, $parentId);
    }

    public static function createForType(string $documentType, array $data): static
    {
        $response = static::resolveClient()->post(static::endpoint()."/{$documentType}", $data);

        return (new static)->fill($response)->syncOriginal()->setExists(true);
    }

    public static function createForParentType(DocumentParentType $type, array $data): static
    {
        return static::createForType($type->value, $data);
    }

    /**
     * @param  array<string, mixed>  $payload  Merged with parentIdentifier; other keys per API (e.g. document kind).
     */
    public static function createForVerkooporder(string $orderId, array $payload = []): static
    {
        return static::createForParentType(
            DocumentParentType::Verkooporder,
            array_merge(['parentIdentifier' => $orderId], $payload),
        );
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function createForOfferte(string $offerteId, array $payload = []): static
    {
        return static::createForParentType(
            DocumentParentType::Offerte,
            array_merge(['parentIdentifier' => $offerteId], $payload),
        );
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function createForVerkoopBoeking(string $boekingId, array $payload = []): static
    {
        return static::createForParentType(
            DocumentParentType::VerkoopBoeking,
            array_merge(['parentIdentifier' => $boekingId], $payload),
        );
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public static function createForInkoopBoeking(string $boekingId, array $payload = []): static
    {
        return static::createForParentType(
            DocumentParentType::InkoopBoeking,
            array_merge(['parentIdentifier' => $boekingId], $payload),
        );
    }

    /**
     * Decodes {@see $content} when it is standard base64; returns null if missing or invalid.
     */
    public function decodedContent(): ?string
    {
        $raw = $this->getAttribute('content');
        if (! is_string($raw) || $raw === '') {
            return null;
        }

        $decoded = base64_decode($raw, true);

        return $decoded === false ? null : $decoded;
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

    /**
     * Normalizes JSON from GET documenten/{type}/{id}: OData `value`, a plain list, or one object.
     *
     * @param  mixed  $data
     * @return Collection<int, static>
     */
    protected static function mapListResponse(mixed $data): Collection
    {
        if (! is_array($data)) {
            return collect();
        }

        if (isset($data['value']) && is_array($data['value'])) {
            return static::mapListResponse($data['value']);
        }

        if ($data === []) {
            return collect();
        }

        if (array_is_list($data)) {
            return collect($data)
                ->filter(fn ($item) => is_array($item))
                ->map(fn (array $item) => (new static)->fill($item)->syncOriginal()->setExists(true));
        }

        return collect([
            (new static)->fill($data)->syncOriginal()->setExists(true),
        ]);
    }
}
