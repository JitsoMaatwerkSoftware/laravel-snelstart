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
        $key = $this->requireKey();

        return static::resolveClient()->get(static::endpoint()."/{$key}/ubl");
    }

    /**
     * Raw UBL XML when the API returns XML from GET verkoopfacturen/{id}/ubl (use when {@see ubl()} is empty because the response is not JSON).
     */
    public function ublXml(): string
    {
        $key = $this->requireKey();

        return static::resolveClient()->getBody(static::endpoint()."/{$key}/ubl", [], [
            'Accept' => 'application/xml, text/xml, */*',
        ]);
    }

    /**
     * PDF bytes when the API exposes GET verkoopfacturen/{id}/pdf (confirm path in developer portal).
     */
    public function pdf(): string
    {
        $key = $this->requireKey();

        return static::resolveClient()->getBody(static::endpoint()."/{$key}/pdf", [], [
            'Accept' => 'application/pdf, application/octet-stream, */*',
        ]);
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

    private function requireKey(): string
    {
        $key = $this->getKey();
        if ($key === null || $key === '') {
            throw new \InvalidArgumentException('Verkoopfactuur must have a primary key (id) for this operation.');
        }

        return $key;
    }
}
