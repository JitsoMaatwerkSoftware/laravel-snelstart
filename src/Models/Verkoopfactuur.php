<?php

namespace Jitso\LaravelSnelstart\Models;

use Illuminate\Support\Collection;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\DataObjects\Identifier;
use Jitso\LaravelSnelstart\Enums\DocumentParentType;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property Identifier|null $verkoopBoeking
 * @property string|null $modifiedOn
 * @property float|null $openstaandSaldo
 * @property string|null $factuurnummer
 * @property string|null $vervalDatum
 * @property Identifier|null $relatie
 * @property string|null $factuurDatum
 * @property float|null $factuurBedrag
 * @property \Illuminate\Support\Collection<int, Identifier>|null $verkoopOrders
 * @property string|null $uri
 */
class Verkoopfactuur extends Model
{
    use CanRead;

    protected static bool $supportsOData = true;

    protected static array $casts = [
        'verkoopBoeking' => Identifier::class,
        'relatie' => Identifier::class,
        'verkoopOrders' => [Identifier::class],
    ];

    public static function endpoint(): string
    {
        return 'verkoopfacturen';
    }

    public function ubl(): array
    {
        return static::resolveClient()->get(static::endpoint()."/{$this->getKey()}/ubl");
    }

    /**
     * PDF bytes when the API exposes GET verkoopfacturen/{id}/pdf (confirm path in developer portal).
     */
    public function pdf(): string
    {
        return static::resolveClient()->getBody(static::endpoint()."/{$this->getKey()}/pdf");
    }

    /** @return Collection<int, Document> */
    public function documents(): Collection
    {
        $key = $this->getKey();
        if ($key === null) {
            return collect();
        }

        return Document::forParentType(DocumentParentType::VerkoopFactuur, $key);
    }
}
