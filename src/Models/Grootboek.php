<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanCreate;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property string|null $modifiedOn
 * @property string|null $omschrijving
 * @property bool|null $kostenplaatsVerplicht
 * @property string|null $rekeningCode
 * @property bool|null $nonactief
 * @property int|null $nummer
 * @property string|null $grootboekfunctie
 * @property string|null $grootboekRubriek
 * @property array|null $rgsCode
 * @property array|null $btwSoort
 * @property string|null $vatRateCode
 * @property string|null $uri
 */
class Grootboek extends Model
{
    use CanCreate;
    use CanRead;

    protected static array $fillable = [
        'omschrijving',
        'kostenplaatsVerplicht',
        'rekeningCode',
        'nonactief',
        'nummer',
        'grootboekfunctie',
        'vatRateCode',
    ];

    protected static array $required = [];

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'grootboeken';
    }
}
