<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanCreate;
use Jitso\LaravelSnelstart\Concerns\CanDelete;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Concerns\CanUpdate;
use Jitso\LaravelSnelstart\Concerns\CanUpsert;
use Jitso\LaravelSnelstart\DataObjects\Adres;
use Jitso\LaravelSnelstart\DataObjects\Identifier;
use Jitso\LaravelSnelstart\DataObjects\VerkooporderRegel;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property Identifier|null $relatie
 * @property string|null $procesStatus
 * @property int|null $nummer
 * @property string|null $modifiedOn
 * @property string|null $datum
 * @property int|null $krediettermijn
 * @property string|null $omschrijving
 * @property string|null $betalingskenmerk
 * @property array|null $incassomachtiging
 * @property Adres|null $afleveradres
 * @property Adres|null $factuuradres
 * @property string|null $verkooporderBtwIngaveModel
 * @property Identifier|null $kostenplaats
 * @property \Illuminate\Support\Collection<int, VerkooporderRegel>|null $regels
 * @property string|null $memo
 * @property string|null $orderreferentie
 * @property float|null $factuurkorting
 * @property Identifier|null $verkoopfactuur
 * @property float|null $totaalExclusiefBtw
 * @property float|null $totaalInclusiefBtw
 * @property bool|null $isOfferte
 * @property string|null $uri
 */
class Offerte extends Model
{
    use CanCreate;
    use CanDelete;
    use CanRead;
    use CanUpdate;
    use CanUpsert;

    protected static array $fillable = [
        'relatie',
        'procesStatus',
        'datum',
        'krediettermijn',
        'omschrijving',
        'betalingskenmerk',
        'incassomachtiging',
        'afleveradres',
        'factuuradres',
        'verkooporderBtwIngaveModel',
        'kostenplaats',
        'regels',
        'memo',
        'orderreferentie',
        'factuurkorting',
        'isOfferte',
    ];

    protected static array $required = [
        'relatie',
        'datum',
    ];

    protected static array $casts = [
        'relatie' => Identifier::class,
        'afleveradres' => Adres::class,
        'factuuradres' => Adres::class,
        'kostenplaats' => Identifier::class,
        'regels' => [VerkooporderRegel::class],
        'verkoopfactuur' => Identifier::class,
    ];

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'offertes';
    }
}
