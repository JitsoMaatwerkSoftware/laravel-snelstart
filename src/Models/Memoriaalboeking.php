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
 * @property array|null $memoriaalBoekingsRegels
 * @property array|null $inkoopboekingBoekingsRegels
 * @property array|null $verkoopboekingBoekingsRegels
 * @property array|null $dagboek
 * @property string|null $uri
 */
class Memoriaalboeking extends Model
{
    use CanCreate;
    use CanDelete;
    use CanRead;
    use CanUpdate;
    use CanUpsert;

    protected static array $fillable = [
        'datum',
        'markering',
        'boekstuk',
        'omschrijving',
        'memoriaalBoekingsRegels',
        'inkoopboekingBoekingsRegels',
        'verkoopboekingBoekingsRegels',
        'dagboek',
    ];

    protected static array $required = [
        'datum',
        'dagboek',
    ];

    public static function endpoint(): string
    {
        return 'memoriaalboekingen';
    }
}
