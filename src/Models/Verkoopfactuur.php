<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\DataObjects\Identifier;
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
}
