<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\DataObjects\Identifier;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property string|null $modifiedOn
 * @property float|null $openstaandSaldo
 * @property string|null $factuurnummer
 * @property string|null $vervalDatum
 * @property Identifier|null $relatie
 * @property string|null $factuurDatum
 * @property float|null $factuurBedrag
 * @property Identifier|null $inkoopBoeking
 * @property string|null $uri
 */
class Inkoopfactuur extends Model
{
    use CanRead;

    protected static bool $supportsOData = true;

    protected static array $casts = [
        'relatie' => Identifier::class,
        'inkoopBoeking' => Identifier::class,
    ];

    public static function endpoint(): string
    {
        return 'inkoopfacturen';
    }
}
