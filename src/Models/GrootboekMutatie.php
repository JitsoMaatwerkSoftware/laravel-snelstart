<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\DataObjects\Identifier;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property Identifier|null $grootboek
 * @property Identifier|null $kostenplaats
 * @property string|null $datum
 * @property string|null $modifiedOn
 * @property Identifier|null $dagboek
 * @property string|null $omschrijving
 * @property float|null $debet
 * @property float|null $credit
 * @property float|null $saldo
 * @property \Illuminate\Support\Collection<int, Identifier>|null $documents
 * @property string|null $boekstuk
 * @property string|null $factuurNummer
 * @property Identifier|null $relatiePublicIdentifier
 * @property string|null $uri
 */
class GrootboekMutatie extends Model
{
    use CanRead;

    protected static bool $supportsOData = true;

    protected static array $casts = [
        'grootboek' => Identifier::class,
        'kostenplaats' => Identifier::class,
        'dagboek' => Identifier::class,
        'documents' => [Identifier::class],
        'relatiePublicIdentifier' => Identifier::class,
    ];

    public static function endpoint(): string
    {
        return 'grootboekmutaties';
    }
}
