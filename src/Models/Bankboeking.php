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
 * @property string|null $modifiedOn
 * @property string|null $datum
 * @property bool|null $markering
 * @property string|null $boekstuk
 * @property bool|null $gewijzigdDoorAccountant
 * @property string|null $omschrijving
 * @property array|null $grootboekBoekingsRegels
 * @property array|null $inkoopboekingBoekingsRegels
 * @property array|null $verkoopboekingBoekingsRegels
 * @property array|null $btwBoekingsregels
 * @property float|null $bedragUitgegeven
 * @property float|null $bedragOntvangen
 * @property array|null $dagboek
 * @property string|null $uri
 */
class Bankboeking extends Model
{
    protected static array $fillable = [
        'datum',
        'markering',
        'boekstuk',
        'omschrijving',
        'grootboekBoekingsRegels',
        'inkoopboekingBoekingsRegels',
        'verkoopboekingBoekingsRegels',
        'btwBoekingsregels',
        'bedragUitgegeven',
        'bedragOntvangen',
        'dagboek',
    ];

    protected static array $required = [
        'datum',
        'bedragUitgegeven',
        'bedragOntvangen',
        'dagboek',
    ];

    use CanCreate;
    use CanDelete;
    use CanRead;
    use CanUpdate;
    use CanUpsert;

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'bankboekingen';
    }
}
