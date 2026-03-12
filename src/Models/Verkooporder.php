<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanCreate;
use Jitso\LaravelSnelstart\Concerns\CanDelete;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Concerns\CanUpdate;
use Jitso\LaravelSnelstart\Concerns\CanUpsert;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property array|null $relatie
 * @property string|null $procesStatus
 * @property int|null $nummer
 * @property string|null $modifiedOn
 * @property string|null $datum
 * @property int|null $krediettermijn
 * @property bool|null $geblokkeerd
 * @property string|null $omschrijving
 * @property string|null $betalingskenmerk
 * @property array|null $incassomachtiging
 * @property array|null $afleveradres
 * @property array|null $factuuradres
 * @property string|null $verkooporderBtwIngaveModel
 * @property array|null $kostenplaats
 * @property array|null $regels
 * @property string|null $memo
 * @property string|null $orderreferentie
 * @property float|null $factuurkorting
 * @property array|null $verkoopfactuur
 * @property array|null $verkoopordersjabloon
 * @property string|null $verkoopOrderStatus
 * @property float|null $totaalExclusiefBtw
 * @property float|null $totaalInclusiefBtw
 * @property array|null $extraHoofdVelden
 * @property string|null $uri
 */
class Verkooporder extends Model
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
        'geblokkeerd',
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
        'verkoopordersjabloon',
        'verkoopOrderStatus',
        'extraHoofdVelden',
    ];

    protected static array $required = [
        'relatie',
        'datum',
    ];

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'verkooporders';
    }

    public function updateProcesStatus(string $status): array
    {
        return static::resolveClient()->put(
            static::endpoint()."/{$this->getKey()}/ProcesStatus",
            ['id' => $this->getKey(), 'procesStatus' => $status],
        );
    }
}
